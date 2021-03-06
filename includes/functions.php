<?php 

//display any ugly timestamp as a nice looking date
function nice_date( $date ){
    $nice_date = new DateTime( $date );
    echo $nice_date->format( 'l, F jS, Y' );
}

// Convert timestamp to Time Ago (1 day ago..)
// https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
function time_ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


//Count the number of approved comments on any post
function count_comments( $id = 0 ){
    //tell the function to use the DB connection from the global scope
    global $DB;
    //write the query
    $result = $DB->prepare('SELECT COUNT(*) AS total
        FROM comments
        WHERE post_id = ?');
    //run it - bind the data to the placeholders
    $result->execute( array( $id ) );
    //check it
    if( $result->rowCount() >= 1 ){
         //loop it
       while( $row = $result->fetch() ){
             //return the count
           echo $row['total'];
       }       
   }   
} //end function

//display the user's profile pic with a default fallback
function show_profile_pic( $profile_pic, $size = 50 ){
    // if blank, get the default
    if( $profile_pic == '' ){
        $profile_pic = 'images/default-user.png';
    }
    echo "<img src='$profile_pic' width='$size' height='$size'>";
}

//display any form's feedback
function show_feedback( &$message = '', &$class = 'error', &$bullets = array() ){
    if( isset( $message ) ){
        ?>
        <div class="feedback <?php echo $class; ?>">
            <h2><?php echo $message; ?></h2>
            <?php if( !empty( $bullets ) ){ ?>
                <ul>
                    <?php 
                    foreach( $bullets AS $bullet ){
                        echo "<li>$bullet</li>";
                    } ?>
                </ul>
            <?php } ?>
        </div>
        <?php 
    } //end if message is set
}

/**
* displays sql query information including the computed parameters.
* Silent unless DEBUG MODE is set to 1 in config.php
* @param [statement handler] $sth -  any PDO statement handler that needs troubleshooting
*/
function debug_statement($sth){
    if( DEBUG_MODE ){
        echo '<pre>';
        $info = debug_backtrace();
        echo '<b>Debugger ran from ' . $info[0]['file'] . ' on line ' . $info[0]['line'] . '</b><br><br>';
        $sth->debugDumpParams();
        echo '</pre>';
    }
}
/*
display a variable if it exists (prevents warnings)
 */
function echo_if_exists( &$var ){
    if( isset( $var ) ){
        echo $var;
    }
}

/* make checkboxes "stick" */
function checked( &$thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'checked';
    }
}

/* make select dropdowns "stick" */
function selected( &$thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'selected';
    }
}

/**
 * check to see if the viewer is logged in
 * @return array|bool false if not logged in, array of all user data if they are logged in
 */

function check_login(){
    global $DB;
    //if the cookie is valid, turn it into session data
    if(isset($_COOKIE['access_token']) AND isset($_COOKIE['user_id'])){
        $_SESSION['access_token'] = $_COOKIE['access_token'];
        $_SESSION['user_id'] = $_COOKIE['user_id'];
    }

   //if the session is valid, check their credentials
    if( isset($_SESSION['access_token']) AND isset($_SESSION['user_id']) ){
        //check to see if these keys match the DB     

     $data = array(
        'id' => $_SESSION['user_id'],
        'access_token' =>$_SESSION['access_token'],
    );

     $result = $DB->prepare(
        "SELECT * FROM users
        WHERE user_id = :id
        AND access_token = :access_token
        LIMIT 1");
     $result->execute( $data );

     if($result){
            //success! return all the info about the logged in user
        return $result->fetch();
    }else{
        return false;
    }
}else{
        //not logged in
    return false;
}
}
/*Make a default avatar from the user's first initial*/
function make_letter_avatar($string, $size){
//random pastel color
    $H =   mt_rand(0, 360);
    $S =   mt_rand(25, 50);
    $B =   mt_rand(90, 96);

    $RGB = get_RGB($H, $S, $B);

    $imageFilePath = 'avatars/' . $string . '_' .  $H . '_' . $S . '_' . $B . '.png';

    //base avatar image that we use to center our text string on top of it.
    $avatar = imagecreatetruecolor($size, $size);  
    //make and fill the BG color
    $bg_color = imagecolorallocate($avatar, $RGB['red'], $RGB['green'], $RGB['blue']);
    imagefill( $avatar, 0, 0, $bg_color );
    //white text
    $avatar_text_color = imagecolorallocate($avatar, 255, 255, 255);
// Load the gd font and write 
    $font = imageloadfont('gd-files/gd-font.gdf');
    imagestring($avatar, $font, 10, 10, $string, $avatar_text_color);

    imagepng($avatar, $imageFilePath);

    imagedestroy($avatar);

    return $imageFilePath;
}


/*
*  Converts HSV to RGB values
*  Input:     Hue        (H) Integer 0-360
*             Saturation (S) Integer 0-100
*             Lightness  (V) Integer 0-100
*  Output:    Array red, green, blue
*/

function get_RGB($iH, $iS, $iV) {
    if($iH < 0)   $iH = 0;   // Hue:
    if($iH > 360) $iH = 360; //   0-360
    if($iS < 0)   $iS = 0;   // Saturation:
    if($iS > 100) $iS = 100; //   0-100
    if($iV < 0)   $iV = 0;   // Lightness:
    if($iV > 100) $iV = 100; //   0-100

    $dS = $iS/100.0; // Saturation: 0.0-1.0
    $dV = $iV/100.0; // Lightness:  0.0-1.0
    $dC = $dV*$dS;   // Chroma:     0.0-1.0
    $dH = $iH/60.0;  // H-Prime:    0.0-6.0
    $dT = $dH;       // Temp variable

    while($dT >= 2.0) $dT -= 2.0; // php modulus does not work with float
    $dX = $dC*(1-abs($dT-1));     // as used in the Wikipedia link

    switch(floor($dH)) {
        case 0:
        $dR = $dC; $dG = $dX; $dB = 0.0; break;
        case 1:
        $dR = $dX; $dG = $dC; $dB = 0.0; break;
        case 2:
        $dR = 0.0; $dG = $dC; $dB = $dX; break;
        case 3:
        $dR = 0.0; $dG = $dX; $dB = $dC; break;
        case 4:
        $dR = $dX; $dG = 0.0; $dB = $dC; break;
        case 5:
        $dR = $dC; $dG = 0.0; $dB = $dX; break;
        default:
        $dR = 0.0; $dG = 0.0; $dB = 0.0; break;
    }

    $dM  = $dV - $dC;
    $dR += $dM; $dG += $dM; $dB += $dM;
    $dR *= 255; $dG *= 255; $dB *= 255;

    return  array(
        'red' =>  round($dR),
        'green'=> round($dG),
        'blue' => round($dB)
    );
}


function show_post_image( $image, $size = 'medium' ){
    echo '<img src="uploads/' . $image . '_' . $size . '.jpg">';
}

//Count the number of likes on any post
function count_likes( $post_id = 0 ){
    global $DB;
    $result = $DB->prepare('SELECT COUNT(DISTINCT user_id) AS total
                            FROM likes
                            WHERE post_id = ?');
    $result->execute( array( $post_id ) );
    $row = $result->fetch();
    return $row['total'];
}


function like_interface( $post_id = 0, &$user_id = 0 ){
    //does the logged_in_user like this post?
    global $DB;
    $result = $DB->prepare('SELECT * FROM likes
                            WHERE user_id = :user_id
                            AND post_id = :post_id
                            LIMIT 1');
    $result->execute( array(
                        'user_id' => $user_id,
                        'post_id' => $post_id,
                    ) );
    if( $result->rowCount() >= 1 ){
        $class='you-like';
    }else{
        $class='not-liked';
    }
    if( $user_id < 1 ){
        $class='not_logged_in';
    }
    ?>
    <span class="like-interface">
        <span class="<?php echo $class; ?>">
            <span class="heart-button" data-postid="<?php echo$post_id; ?>">???</span>
            <?php echo count_likes( $post_id ); ?>
        </span>
    </span>
    <?php
}


//no close php



