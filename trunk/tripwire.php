<pre><?php

/*
 *  Tripwire
 *  Luke Stevenson <www.lucanos.com>
 *
 *  This is a PHP script which will scan files within a directory (including
 *    sub-directories), calculate their MD5 Hashes and then compare them against
 *    a log of the results from the previous execution to determine any files
 *    which have been added, deleted or modified during that period.
 *
 *  Within the Configuration Settings, exclusions can be set for any files/folders
 *    which should not be checked.
 *
 *  For best results, this file should be triggered by a cron job at regular intervals.
 *    Also, be sure to add your email address to the Configuration Settings to ensure
 *    that you recieve the notifications.
 *
 */

$config = array(

  'md5file' => 'tripwire_filelist.md5' , // File Containing the MD5 Keys
  'delim' => '&&&' ,            // Delimited for Filelist

  'exclude' => array(
    'files' => array(         // Files to Exclude from Scanning
      '.' ,
      '..' ,
      'tripwire_filelist.md5' ,
      'error_log' ,
      'backup.zip' ,
      '.bash_history'
    ) ,
    'extns' => array(         // Extensions to Exclude from Scanning
      'flv' ,
      'log' ,
      'txt' ,
      'mp4' ,
      'mov' ,
      'psd' ,
      'swf' ,
      'mno' ,
      'jpg' ,
      'aif' ,
      'doc' ,
      'webm' ,
      'ogv' ,
      'afm' ,
      'sitx'
    )
  ) ,

  'email' => array(
    'to' => array(            // Email these people on changes
      // 'user@server.com'
    ) ,
    'title' => '[Tripwire] Change Detected - [X] Files' , // The Email Title
    'body' => "Tripwire (https://github.com/lucanos/Tripwire) has detected a number of changes:\n\n[AN] Files Added:\n[AF]\n\n[MN] Files Modified:\n[MF]\n\n[DN] Files Deleted:\n[DF]\n\n"   // The Email Template
  )

);



function makeHash( $dir=false ){
  global $config, $filelist;
  
  if( !$dir )  // Default to the Root of the Site the script is executed under
    $dir = $_SERVER['DOCUMENT_ROOT'];

  if( substr( $dir , -1 )=='/' )  // Strip slash from end of directory
    $dir = substr( $dir , 0 , -1 );

  if( !is_dir( $dir ) )  // If the supplied variable is not a Directory, terminate
    return false;

  $temp = array();
  $d = dir( $dir );

  while( false!==( $entry = $d->read() ) ){  // Loop through the files
    if( is_link( $entry ) ){
      continue;  // Symbolic Link - Excluded
    }
    if( in_array( $entry , $config['exclude']['files'] ) ){
      continue;  // Excluded File/Folder
    }
    if( in_array( pathinfo( $entry , PATHINFO_EXTENSION ) , $config['exclude']['extns'] ) ){
      continue;  // Excluded File Extension
    }
    if( is_dir( $dir.'/'.$entry ) ){
      // Recurse
      $temp = array_merge( $temp , makeHash( $dir.'/'.$entry ) );
    }else{
      $md5 = @md5_file( $dir.'/'.$entry );
      if( !$md5 ){
        file_put_contents( 'tripwire_unreadable.txt' ,  "{$dir}/{$entry} - Unreadable\n" , FILE_APPEND );
      }else{
        $temp[$dir.'/'.$entry] = $md5;
      }
    }
  }

  $d->close();

  return $temp;

}


// In case file_put_contents does not exist
if( !function_exists( 'file_put_contents' ) ){
  function file_put_contents( $filename , $data ){
    $f = @fopen( $filename , 'w' );
    if( !$f )
      return false;
    $bytes = fwrite( $f , $data );
    fclose( $f );
    return $bytes;
  }
}


// Init the Last Check List
$last = array();


// Access the MD5 File List, if it exists
if( file_exists( $config['md5file'] ) ){
  $temp = file( $config['md5file'] , FILE_SKIP_EMPTY_LINES );

  // Split the MD5 File List into Filename and MD5 Hash
  foreach( $temp as $line ){
    list( $filename , $md5hash ) = explode( $config['delim'] , str_replace( "\n" , '' , $line ) );
    $last[$filename] = $md5hash;
  }

  unset( $temp );
}



// Init the This Check List
$now = makeHash( '.' );



// Perform Comparisons

// New Files = Files in $now, but not in $last
$new = array_diff( array_keys( $now ) , array_keys( $last ) );

// Deleted Files = Files in $last, but not in $now
$deleted = array_diff( array_keys( $last ) , array_keys( $now ) );

// Changed Files = Files in $last and $now, but with Different MD5 Hashes
$modified = array_diff_assoc( array_intersect_key( $last , $now ) , array_intersect_key( $now , $last ) );



echo "\$new\n";
var_dump( $new );

echo "\$deleted\n";
var_dump( $deleted );

echo "\$modified\n";
var_dump( $modified );



if( !count( $last ) // If there was no file list
    || ( count( $new ) || count( $deleted ) || count( $modified ) ) ){ // Or a change was detected

  # Update the file list
  
  // Init an Array for Lines
  $log = array();

  // Compress the MD5 Hash Array into lines
  foreach( $now as $k => $v )
    $log[] = "{$k}{$config['delim']}{$v}";

  // Write to the File List
  file_put_contents( $config['md5file'] , implode( "\n" , $log ) );

}




if( count( $last ) // If there was a Filelist from the last run to compare against
    && ( count( $new ) || count( $deleted ) || count( $modified ) ) ){ // And changes occurred
  
  # Changes Detected
  
  if( count( $config['email']['to'] ) ){ // If there are email addresses to notify
  
    # Compile the Email
    
    // Prepare the placeholder details
    $body_replacements = array(
      '[AN]' => count( $new ) ,
      '[AF]' => ( count( $new ) ? implode( "\n" , $new ) : 'No Files' ) ,
      '[MN]' => count( $modified ) ,
      '[MF]' => ( count( $modified ) ? implode( "\n" , array_keys( $modified ) ) : 'No Files' ) ,
      '[DN]' => count( $deleted ) ,
      '[DF]' => ( count( $deleted ) ? implode( "\n" , $deleted ) : 'No Files' ) ,
    );
    
    // Prepare the recipients
    $to = implode( ', ' , $config['email']['to'] );
    // Prepare the Subject Line
    $title = str_replace( '[X]' , ( count( $new )+count( $deleted )+count( $modified ) ) , $config['email']['title'] );
    // Perform the Placeholder Substitutions within the Body
    $body = str_replace(
              array_keys( $body_replacements ) ,
              $body_replacements ,
              $config['email']['body']
            );
    
    // Send it
    if( mail( $to , $title , $body ) ){
      echo "Email Sent Successfully\n";
    }else{
      echo "Email Failed\n";
    }
  
  }

}else{

  # No Changes Detected

}