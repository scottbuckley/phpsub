<?php
 #####
#     #  ####  #    # ###### #  ####  #    # #####    ##   ##### #  ####  #    #
#       #    # ##   # #      # #    # #    # #    #  #  #    #   # #    # ##   #
#       #    # # #  # #####  # #      #    # #    # #    #   #   # #    # # #  #
#       #    # #  # # #      # #  ### #    # #####  ######   #   # #    # #  # #
#     # #    # #   ## #      # #    # #    # #   #  #    #   #   # #    # #   ##
 #####   ####  #    # #      #  ####   ####  #    # #    #   #   #  ####  #    #

$OPT_SQL_FILENAME = 'sub.db';
$OPT_MUSICDIR = '/home2/buckly/nonpublic/submusic/'; // with trailing slash !IMPORTANT!
$OPT_LETTERGROUPS = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','XYZ', '#');
$OPT_NONALPHALETTERGROUP = '#';
$OPT_ARTICLES = array('The');
$OPT_IGNOREDFOLDERS = array('..', '.');
$OPT_ACCEPTED_FILE_TYPES = array('.mp3');
$OPT_SCAN_COUNTPERREFRESH = 75;
define('IMG_ICON', 'image/gif;base64,R0lGODlhDAAMAJECAAAAAJaWlv///wAAACH5BAEAAAIALAAAAAAMAAwAAAIZlI+pGe2NgpKHxssOAGobn4AgInKhuaRpAQA7');
define('TIME_2033', 2000000000);
define('REQUIRE_AUTH', true);

#     # ####### #     # #
#     #    #    ##   ## #
#     #    #    # # # # #
#######    #    #  #  # #
#     #    #    #     # #
#     #    #    #     # #
#     #    #    #     # #######



// the root page for phpsub's HTML frontend
function webHome($style='htmlStyle', $script='htmlScript', $body='htmlBody') { ?>
<html>
    <head>
        <meta charset="UTF-8">

        <!-- EXTERNAL JS  -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"            ></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"          ></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js" ></script>

        <!-- EXTERNAL CSS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,900'          rel='stylesheet' type='text/css'>
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"   rel="stylesheet" type="text/css">

        <link rel="icon" type="img/ico" href="data:<?php echo IMG_ICON; ?>">
<?php $style();  ?>
<?php $script(); ?>
        <title>phpsub</title>
    </head>
    <body>
<?php $body(); ?>
    </body>
</html>
<?php }

function htmlBody() { ?>
        <div class="globalWrapper">
            <div class="innerWrapper">
                <div class="leftPanelWrapper">
                    <div class="leftPanel"></div>
                </div>
                <div class="centrePanelWrapper">
                    <div class="centrePanel">&nbsp;</div>
                </div>
                <div class="rightPanelWrapper">
                    <div class="rightPanel">
                        <audio id="htmlAudio" controls autoplay></audio>
                        <table id="trackListTable"></table>
                        <a href="javascript:prevTrack();">prev</a>
                        <a href="javascript:nextTrack();">next</a>
                        <a href="javascript:startTrack();">play</a>
                    </div>
                </div>
            </div>
            <!-- <tr> -->
                <!-- <td colspan="3"><div style="border:1px solid red;">all the stuff!!!!</div></td> -->
                <!-- <td colspan="3"><div style="border:1px solid blue;">all the stuff!!!!</div></td> -->
            <!-- </tr> -->
            <div class="footerWrapper">
                <div class="footer">
                    <a href="?/signout">Sign Out</a>
                </div>
            </div>
        </div>
<?php }

function htmlBadAuth() {
    webHome(
        'htmlStyle',
        '·',
function() { ?>
    <div class="loginContainer">
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Please sign in to phpsub</h2>
        <input type="text"     class="form-control" placeholder="Username" name="frmUsr" required autofocus>
        <input type="password" class="form-control" placeholder="Password" name="frmPwd" required>
        <?php postLoginFailAlert(); ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div>
<?php });
}

function postLoginFailAlert() {
    if (¿($GLOBALS, 'loginPostTried')) { ?>
        <div class="alert alert-danger fade in">
            <strong>Bad work bro.</strong> Your username and password didn't work. Try again I guess.
        </div>
        <script type="text/javascript"> $(".alert").delay(4000).slideUp(2000); </script>
    <?php }
}

 #####   #####   #####
#     # #     # #     #
#       #       #
#        #####   #####
#             #       #
#     # #     # #     #
 #####   #####   #####


function htmlStyle() { ?>
        <style type="text/css">
            body {
                font-family: 'Roboto', sans-serif;
                font-weight: 100;
                padding: 5px;
            }
            table {
                font-family:  inherit;
                font-size:    inherit;
                font-style:   inherit;
                font-variant: inherit;
                font-weight:  inherit;
            }
            div.globalWrapper {
                display: table;
                width: 100%;
                height: 100%;
                table-layout: fixed;
            }
            div.innerWrapper {
                display: table-row;
            }
            div.footerWrapper {
                display: table-row;
                height: 40px;
            }
            
            div.footer, div.leftPanelWrapper, div.rightPanelWrapper, h1 {
                border-radius: 5px;
                border: 1px solid #DDD;
            }

            div.footer {
                display: table-cell;
                height: 35px;
                position: absolute;
                left:   0px;
                right:  0px;
                margin: 5px;
                background: #EEE;
                padding: 5px;
            }
            div.leftPanelWrapper {
                display: table-cell;
                vertical-align: top;
                width: 200px;
                overflow: hidden;
                background-color: #EEE;
            }
            div.leftPanel {
                position: static;
                overflow: auto;
                height: 100%;
            }
            div.centrePanelWrapper {
                display: table-cell;
                vertical-align: top;
            }
            div.rightPanelWrapper {
                background-color: #EEE;
                width: 300px;
                display: table-cell;
            }
            div.centrePanel {
                overflow:scroll;
                height:100%;
                padding: 0px 10px;
            }
            div.rightPanel {
                padding: 5px;
            }
            div.indexGroup {

            }
            div.indexGroupHeader {
                font-weight: 700;
                background-color: #BBB;
                padding-left: 8px;
            }
            div.indexItem {
                font-size: 10pt;
                padding-left: 12px;
            }
            div.indexItem:hover {
                background-color: #CCC;
            }
            a.indexItemAnchor {
                color: #000;
                text-decoration: none;
                width: 100%;
                display: block;
            }
            table#trackListTable {
                font-size: 8pt;
                width: 100%;
            }
            .playingTrack {
                font-weight: 400;
            }
            h1 {
                font-weight: 400;
                background-color: #EEE;
                margin: 0;
                border-radius: 5px;
                overflow: hidden;
            }
            #titleWrapper {
                display:table-row;
            }
            #directoryTitle {
                display:table-cell;
                padding-left: 8px;
            }
            #backButton {
                width: 10px;
                font-family: 'FontAwesome';
                background-color: #CCC;
                font-size: 20px;
                color: #AAA;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
                text-decoration: none;
            }


            /* Login Screen */
            .loginContainer {
                width:             100%;
                height:            100%;
                background-color:  #EEE;
                padding-top:       40px;
                padding-bottom:    40px;
                border-radius:     5px;
            }
            .form-signin {
                max-width:  400px;
                padding:    25px;
                margin:     0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom:  10px;
            }
            .form-signin .checkbox {
                font-weight:  normal;
            }
            .form-signin .form-control {
                position:            relative;
                height:              auto;
                -webkit-box-sizing:  border-box;
                   -moz-box-sizing:  border-box;
                        box-sizing:  border-box;
                padding:             10px;
                font-size:           16px;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                margin-bottom:              -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius:  0;
            }
            .form-signin input[type="password"] {
                margin-bottom:              10px;
                border-top-left-radius:     0;
                border-top-right-radius:    0;
            }
        </style>
<?php }

      #                       #####
      #   ##   #    #   ##   #     #  ####  #####  # #####  #####
      #  #  #  #    #  #  #  #       #    # #    # # #    #   #
      # #    # #    # #    #  #####  #      #    # # #    #   #
#     # ###### #    # ######       # #      #####  # #####    #
#     # #    #  #  #  #    # #     # #    # #   #  # #        #
 #####  #    #   ##   #    #  #####   ####  #    # # #        #


function htmlScript() { ?>
        <script type="text/javascript">

            //semi-globals
            var currentTracks = Array();
            var currentTrackIndex = 0;
            var isPlaying = false;

            $.fn.exists   = function () { return this.length !== 0; }
            $.fn.orreturn = function (def) { return this.exists() ? this : def; }
            $.fn.orrun    = function (foo) { return foo(); };


            $(function() {

                //bind event listeners
                $(window).bind('hashchange', hashResponse);

                $('#htmlAudio')
                    .on('ended',   audEnded)
                    .on('canplay', audCanPlay)
                    .on('play',    audPlay)
                    .on('pause',   audPause);

                // do straight away
                hashResponseMaybe();
                loadIndexes();
            });

            function audEnded() {
                isPlaying = false;
                nextTrack();
            }

            function audPlay() {
                isPlaying = true;
            }

            function audCanPlay() {}
            function audPause() {}

            function nextTrack() {
                moveTrack(1);
            }

            function prevTrack() {
                moveTrack(-1);
            }

            function startTrack() {
                moveTrack(0);
            }

            function getCurTrack() {
                var cur = $('.trackTR.playingTrack').first();
                if (!cur.exists()) {
                    cur = $('.trackTR').first();
                    cur.addClass('playingTrack');
                }
                return cur;
            }

            function moveTrack(change) {

                // the currently playing track
                var oldTR = getCurTrack();
                oldTR.removeClass('playingTrack');

                // choose and select the next track
                var newTR = oldTR;
                while (change > 0) {
                    newTR = newTR.next('.trackTR');
                    change--;
                }
                while (change < 0) {
                    newTR = newTR.prev('.trackTR');
                    change++;
                }
                newTR.addClass('playingTrack');

                // play the track.
                var newTrack = newTR.attr('subid');
                $('#htmlAudio')
                    .empty()
                    .append($('<source>', {
                          id    : 'htmlAudioSource'
                        , subid : newTrack
                        , type  : 'audio/mpeg'
                        , src   : '?/rest/stream.view?id='+newTrack
                    }));
            }

            function selectTrack(tid) {

                var dTrackTable = $('#trackListTable');

                currentTracks.push(tid);
                dTrackTable.append($('<tr>', {
                      class : 'trackTR'
                    , id    :'track'+tid
                    , subid : tid
                }).load('?/web/track_tr?id='+tid));

                if (!isPlaying) {
                    startTrack();
                }

            }

            function loadDirectory(dirId) {
                $(".centrePanel").load("?/web/directory?id=" + dirId, function() {

                    // clicking on titles plays track
                    $(".dirFileTitle").click(function() {
                        var id = $(this).attr("subid");
                        selectTrack(id);
                    });

                    // the back button
                    $("#backButton")
                        .html('&#xf0d9;')
                        .hover(function() {
                            $(this).stop().animate({
                                  width    : 40
                                , fontSize : 40
                            });
                        }
                        , function() {
                            $(this).stop().animate({
                                  width    : 10
                                , fontSize : 20
                            });
                        });
                });
            }

            function loadIndexes() {
                $(".leftPanel").load("?/web/indexes");
            }

            function hashResponse() {

                // remove leading hash and slash
                var hash = location.hash.replace( /^#/, "" );
                var hash = hash.replace( /^\//, "" );

                // process id, if present
                var id = parseInt(hash);
                if (isNaN(id)) {
                    goToRoot();
                } else {
                    loadDirectory(id);
                }
            }

            function hashResponseMaybe() {
                if (!(location.hash===''))
                    hashResponse();
            }
            function goToRoot() {
                window.location  = "#";
            }
        </script>
<?php }

   #                             #####
  # #        #   ##   #    #    #     #  ####  #    # ##### ###### #    # #####
 #   #       #  #  #   #  #     #       #    # ##   #   #   #      ##   #   #
#     #      # #    #   ##      #       #    # # #  #   #   #####  # #  #   #
#######      # ######   ##      #       #    # #  # #   #   #      #  # #   #
#     # #    # #    #  #  #     #     # #    # #   ##   #   #      #   ##   #
#     #  ####  #    # #    #     #####   ####  #    #   #   ###### #    #   #



function webIndexes() { 
    $indexes = splitIntoSubarrays(dbGetIndexes());

    foreach(array_keys($indexes) as $index) {
        »("<div class='indexGroup'><div class='indexGroupHeader'>$index</div>");

        // add artists to index
        foreach($indexes[$index] as $artist) {
            $id   =   $artist['id'];
            $name = §($artist['name']);

            »("<div class='indexItem'><a class='indexItemAnchor' href='#/$id'>$name</a></div>");
            »("<div class='indexItem'><a class='indexItemAnchor' href='#/$id'>$name</a></div>");
            »("<div class='indexItem'><a class='indexItemAnchor' href='#/$id'>$name</a></div>");
            »("<div class='indexItem'><a class='indexItemAnchor' href='#/$id'>$name</a></div>");
        }
        »("</div>");
    }
}

function webDirectory() {
    $id       = intval($_REQUEST['id']);
    $folders  = dbGetSubFolders($id);
    $files    = dbGetSubFiles($id);
    $parentId = dbGetParentId($id);

    $parentName = §(¿D(¿D(null, $folders, 0, 'parentname'), $files, 0, 'parentname'));

    if ($parentId) {
        »("<h1><div id='titleWrapper'><a id='backButton' href='#/$parentId'></a><span id='directoryTitle'>$parentName</span></div></h1>");
    } else {
        »("<h1><span id='directoryTitle'>$parentName</span></h1>");
    }


    // print subfolders
    foreach ($folders as $folder) {
        $name = §($folder['name']);
        $id   =   $folder['id'];

        »("<div class='dirFolder'><a href='#/$id'>$name</a></div>");
    }

    // print files
    if (count($files) > 0) {

        »("<table class='dirFilesTable'>");
        »("<tr><th>#</th><th>Title</th><th>Duration</th></tr>");

        foreach ($files as $file) {
            $id       = $file['id'];
            $track    = §($file['trackint']);
            $title    = §($file['title']);
            $duration = minSecs($file['duration']);

            »("<tr><td>$track</td><td class='dirFileTitle' subid='$id'>$title</td><td>$duration</td></tr>");
        }
        »("</table>");
    }
}

function webTrackTR() {
    $id = intval($_REQUEST['id']);
    $track = dbGetTrack($id);
    
    $id       =       §($track['id']);
    $title    =       §($track['title']);
    $duration = minSecs($track['duration']);

    echo "<td>$title</td><td>$duration</td>";
}

function minSecs($time) {
    // seconds
    $secs = ½($time % 60);
    $time = floor($time / 60);

    // mins
    $mins = ½($time % 60);
    $time = floor($time / 60);

    // hrs
    $hrs  = $time;

    //output
    if ($hrs == 0) {
        return "$mins:$secs";
    } else {
        return "$hrs:$mins:$secs";
    }
}

   #
  # #   #    # ##### #    #
 #   #  #    #   #   #    #
#     # #    #   #   ######
####### #    #   #   #    #
#     # #    #   #   #    #
#     #  ####    #   #    #

function badAuth($requestPath) {
    if (startsWith($requestPath, '/rest/')) {
        restBadAuth();
    } else {
        htmlBadAuth();
    }
}

function checkAuth() {

    // check cookie
    $cookie_un = ¿($_COOKIE, 'phpsub_auth', 'un');
    $cookie_pw = ¿($_COOKIE, 'phpsub_auth', 'pw');

    if ($cookie_un && $cookie_pw)
        if(dbCheckUserPass($cookie_un, unhex($cookie_pw)))
            return true;
    

    // check POST    
    $post_un = ¿($_POST, 'frmUsr');
    $post_pw = ¿($_POST, 'frmPwd');

    if ($post_un && $post_pw)
        if(dbCheckUserPass($post_un, $post_pw)) {
            makeAuthCookie($post_un, $post_pw);
            return true;
        }
        else
            $GLOBALS['loginPostTried'] = true;


    // check GET
    $get_un = ¿($_REQUEST, 'u');
    $get_pw = ¿($_REQUEST, 'p');

    if ($get_un && $get_pw)
        if(dbCheckUserPass($cookie_un, unhex($cookie_pw)))
            return true;

    // fail
    return false;
}

function makeAuthCookie($un, $pw) {
    setcookie(
          'phpsub_auth[un]'
        , $un
        , TIME_2033
    );
    setcookie(
          'phpsub_auth[pw]'
        , hex($pw)
        , TIME_2033
    );

    // also we will force a refresh
    forceRefresh();
}

function authSignOut() {
    // delete the cookies
    setcookie(
          'phpsub_auth[un]'
        , ''
        , time()-1
    );
    setcookie(
          'phpsub_auth[pw]'
        , ''
        , time()-1
    );

    // also we will force a refresh
    forceRefresh();   
}

function unhex($pw) {
    if (startsWith($pw, 'enc:'))
        return my_hex2bin(substr($pw, 4));
    return $pw;
}

function hex($pw) {
    if (startsWith($pw, 'enc:'))
        return $pw;
    return 'enc:'.bin2hex($pw);
}

// versions of PHP less than 5.4 don't have hex2bin
function my_hex2bin($h) {
    if (!is_string($h)) return null;
    $r = '';
    for ($a = 0; $a < strlen($h); $a += 2) {
        $r .= chr(hexdec($h{$a}.$h{($a + 1)}));
    }
    return $r;
}


 #####
#     # #        ##    ####   ####  ######  ####
#       #       #  #  #      #      #      #
#       #      #    #  ####   ####  #####   ####
#       #      ######      #      # #           #
#     # #      #    # #    # #    # #      #    #
 #####  ###### #    #  ####   ####  ######  ####

class ResponseObject {
    private $name;
    private $properties;
    private $children;

    public function ResponseObject($name, $props=array(), $children=array()) {
        $this->name       = $name;
        $this->properties = is_array($props)                      ? $props           : array();
        $this->children   = ($children instanceof ResponseObject) ? array($children) : $children;
    }

    public function addChild($newChild) {
        if ($newChild instanceof ResponseObject) {
            $this->children[] = $newChild;
        }
    }

    public function setProperties($props) {
        if (is_array($props)) {
            $this->properties = $props;
        }
    }

    public function getName() {
        return $this->name;
    }

    public function render($status='ok') {
        $f = getAPIFormatType();
        if ($f=='xml')
            return $this->renderXML($status);
        if ($f=='json')
            return $this->renderJSON($status);
    }

    public function renderJSON($status='ok') {
        setContentType('JSON');
        $res = $this->wrapInSubsonicResponse($status);

        return "{\n".$res->toJSON(1)."\n}";
    }

    public function renderXML($status='ok') {
        setContentType('XML');
        $res = $this->wrapInSubsonicResponse($status);

        return '<?xml version="1.0" encoding="UTF-8"?>'.$res->toXML(0);
    }

    private function toJSON($indent=0, $printName=true) {
        $name  = $this->name;
        $props = $this->properties;
        $chren = $this->flatChildren();
        $count = 1; // for commas.

        // indent string and previous indent strings
        $ind =  str_repeat('  ', $indent+1);
        $pind = str_repeat('  ', $indent);

        // possibly print the 'name' of this object
        if ($printName)
            $newJSON = "$pind\"$name\": {";
        else
            $newJSON = "\n$pind{";

        // print properties
        foreach($props as $key => $value) {
            $safeValue = safeJSONencode($value);
            $pref = $this->commaStart($count++, "\n");
            $newJSON .= "$pref$ind\"$key\": $safeValue";
        }

        //children (flatten common children into lists)
        foreach($chren as $name => $chlist) {
            if (count($chlist) == 1) {
                $pref = $this->commaStart($count++, "\n");
                $newJSON .= $pref . $chlist[0]->toJSON($indent+1);
            } else {
                $pref = $this->commaStart($count++, "\n");
                $newJSON .= "$pref$ind\"$name\": [";

                $inCount=1;
                foreach($chlist as $child) {
                    $inPref = $this->commaStart($inCount++, '');
                    $newJSON .= $inPref . $child->toJSON($indent+2, false);
                }
                $newJSON .= "\n$ind]";
            }
        }

        // print children, without flattening children into lists
        // if (is_array($chren)) {
        //     foreach($chren as $child) {
        //         $childJSON = $child->toJSON($indent+1);

        //         $pref = $this->commaStart($count++, "\n");
        //         $newJSON .= "$pref$childJSON";
        //     }
        // }

        $newJSON .="\n$pind}";

        return $newJSON;
    }

    // returns a list of lists of children, where the top-level list has
    // keys matching the 'name' of it's array of children.
    private function flatChildren() {
        $flatList = array();
        foreach($this->children as $child) {
            $flatList[$child->name][] = $child;
        }
        return $flatList;
    }

    private function toXML($indent=0) {
        $name  = $this->name;
        $props = $this->properties;
        $chren = $this->children;
        if ($name=='') return '';

        $ind = str_repeat("  ", $indent);
        $newXML = "\n$ind<$name";

        //properties
        foreach ($props as $key => $value) {
            $safeValue = safeXMLencode($value);
            $newXML .= " $key=\"$safeValue\"";
        }

        //children
        // we don't use the /> notation if there are children OR there are no properties.
        if ((is_array($chren) && !empty($chren)) || empty($props)) {
            $newXML .= ">";
            foreach ($chren as $child) {
                $newXML .= $child->toXML($indent+1);
            }
            $newXML .= "\n$ind</$name>";
        } else {
            $newXML .= "/>";
        }

        return $newXML;
    }

    private function wrapInSubsonicResponse($status='ok') {
        return new ResponseObject('subsonic-response', array
            ( 'xmlns'   => 'http://subsonic.org/restapi'
            , 'status'  => $status
            , 'version' => '1.9.0'
            ), $this);
    }

    // add a comma to the start of the string, unless count is one.
    // this is used to create lists with commas in the middle (before each
    // item except the first item)
    private function commaStart($count, $always='') {
        if ($count==1) {
            return $always;
        } else {
            return ','.$always;
        }
    }

}


######
#     #   ##   #####   ##
#     #  #  #    #    #  #
#     # #    #   #   #    #
#     # ######   #   ######
#     # #    #   #   #    #
######  #    #   #   #    #

function getTemplate($templateName) {
    switch($templateName) {
        case 'NOTFOUND': return 
"<html>
    <title>Not found :(</title>
    <body>
        <p>It looks like your page was nooot found :(</p>
        <p>You requested $_SERVER[REQUEST_URI]</p>
    </body>
</html>";

        case 'DBACCESSERROR': return
'Unfortunately we were unable to create/access a database file. Make sure there is write access to this folder.';

        default: return 'TEMPLATE "$templateName" NOT FOUND';
    }
}





######                            #    ######  ###
#     # ######  ####  #####      # #   #     #  #
#     # #      #        #       #   #  #     #  #
######  #####   ####    #      #     # ######   #
#   #   #           #   #      ####### #        #
#    #  #      #    #   #      #     # #        #
#     # ######  ####    #      #     # #       ###


function invalidPage() {
    header('HTTP/1.1 404 Not Found');
    setContentType('HTML');
    echo getTemplate('NOTFOUND');
}

function getIndexes() {
    $indexes = dbGetIndexes();
    $indexes = splitIntoSubarrays($indexes);
    
    $response = formatIndexesXML($indexes);
    echo $response->render();
}

function getMusicDirectory() {
    $id = $_REQUEST['id'];
    $folders = dbGetSubFolders($id);
    $files = dbGetSubFiles($id);

    $response = formatMusicDir($id, $folders, $files);
    echo $response->render();
}

function getCoverArt() {
    $id = $_REQUEST['id'];
    $size = nonzero($_REQUEST['size'], 100);
    if (!streamCoverArt($id, $size)) {
        header('HTTP/1.1 404 Not Found');
        echo "Sorry, the art doesn't seem to exist :(";
    }

}

function getMusicFolders() {
    $response = new ResponseObject('musicFolders', null, 
        new ResponseObject('musicFolder', array(
              'id' => 0
            , 'name' => 'Music'
        )));

    echo $response->render();
}

function getRandomSongs() {
    $response = new ResponseObject('randomSongs');
    echo $response->render();
}

function getStarredSongs() {
    $response = new ResponseObject('starred');
    echo $response->render();
}

function ping() {
    $response = new ResponseObject('');
    echo $response->render();
}

function getLicense() {
    $response = new ResponseObject('license', array('valid' => 'true'));
    echo $response->render();
}

function stream() {
    setContentType('MPEG');
    $id = $_REQUEST['id'];
    streamMP3($id);
}

function createDB() {
    dbCreateTables();
}

function scanEverything() {
    echo "Scanning Indexes...";
    scanIndexes();
    echo "Scanning folders...";
    scanAllFolders();
}

function restBadAuth() {
    $response = new ResponseObject('error', array(
          'code'    => 40
        , 'message' => 'Wrong username or password'
    ));
    echo $response->render('failed');
}

function scanTracks_First() {
    echo "<p>scanning mp3 data</p>";
    scanMP3Info_First();
    echo '
<script language="javascript" type="text/javascript">
    setTimeout(function() {
        //window.location.href=window.location.href;
    }, 800);
</script>
';
}

function scanTracks_Second() {
    echo "<p>scanning mp3 data, second pass</p>";
    scanMP3Info_Second();
}



 
#     #
##   ## ###### #####   ##
# # # # #        #    #  #
#  #  # #####    #   #    #
#     # #        #   ######
#     # #        #   #    #
#     # ######   #   #    #

function forceRefresh() {
    header('Location: '.parse_url($_SERVER['REQUEST_URI'])['path']);
    die;
}

function getPageMap() {
    return array
          // URIs for the RESTful API
        ( '/rest/getMusicDirectory.view'  => 'getMusicDirectory'
        , '/rest/getMusicFolders.view'    => 'getMusicFolders'
        , '/rest/getRandomSongs.view'     => 'getRandomSongs'
        , '/rest/getCoverArt.view'        => 'getCoverArt'
        , '/rest/getStarred.view'         => 'getStarredSongs'
        , '/rest/getIndexes.view'         => 'getIndexes'
        , '/rest/getLicense.view'         => 'getLicense'
        , '/rest/stream.view'             => 'stream'
        , '/rest/ping.view'               => 'ping'

        // URIs for the HTML frontend
        , '/home'           => 'webHome'
        , '/web/indexes'    => 'webIndexes'
        , '/web/directory'  => 'webDirectory'
        , '/web/track_tr'   => 'webTrackTR'

        // URIs for performing other functions
        , '/signout'        => 'authSignOut'
        , '/web/scan'       => 'scanEverything'
        , '/web/scan2'      => 'scanTracks_First'
        , '/web/createdb'   => 'createDB'
        );
}


/* because pspsub is one file, and we need to deal with lots of different
 * URLs for the API, we define the root path (for apis) to be [foldername]/?/
 * this allows this one PHP file to process every request.
 */
function processURI() {
    // defaults
    $pageFunc    = 'webHome';
    $requestPath = null;

    // use the path to decide what to do
    $rawPath     = $_SERVER['REQUEST_URI'];
    if (strpos($rawPath, '/?/') !== false) {
        // discard the /?/
        $relPath = substr($rawPath, strpos($rawPath, '/?/')+2);

        // reparse the query string
        $pathInfo = parse_url($relPath);
        if (isset($pathInfo['query'])) {
            $requestQuery = $pathInfo['query'];
            parse_str($requestQuery, $a);
            $_REQUEST = array_merge($_REQUEST, $a);
        }

        // figure out which page to generate
        $requestPath = $pathInfo['path'];
        $pageFunc = getByMatch($requestPath, getPageMap());

        if (!$pageFunc) {
            invalidPage();
            return;
        }
    }

    // check for authentication before performing page generation
    if (checkAuth() || (!REQUIRE_AUTH)) {
        $pageFunc();
    } else {
        badAuth($requestPath);
    }
}

function getAPIFormatType() {
    $format = 'xml';
    if (rqst('f') == 'json')
        $format = 'json';
    return $format;

}

function streamMP3($id) {
    $fname = dbGetMP3filename($id);
    header("Content-Length: ".filesize($fname));
    fpassthru(fopen($fname, 'rb'));
    exit;
}



###
 #  #    #   ##    ####  ######
 #  ##  ##  #  #  #    # #
 #  # ## # #    # #      #####
 #  #    # ###### #  ### #
 #  #    # #    # #    # #
### #    # #    #  ####  ######

function streamCoverArt($id, $size) {
    $thumbPath = "thumbs/id".$id."_size".$size.".jpg";
    if (thumbFromCache($thumbPath))
        return true;
    if (thumbFromFolderJPG($id, $size, $thumbPath))
        return true;
    return false;
}
function thumbFromCache($thumbPath) {
    if (file_exists($thumbPath)) {
        setContentType('JPEG');
        fpassthru(fopen($thumbPath, 'rb'));
        return true;
    }
    return false;
}
function thumbFromFolderJPG($id, $size, $thumbPath) {
    $fname = dbGetFolderPath($id)."/Folder.jpg";
    if (file_exists($fname)) {
        generateThumb($fname, $id, $size, $thumbPath);
        return true;
    }
    return false;
}
function generateThumb($fname, $id, $size, $thumbPath) {
    // load and resize image
    list($width, $height) = getimagesize($fname);
    $oldImage   = imagecreatefromjpeg($fname);
    $newImage = imagecreatetruecolor($size, $size);
    imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $size, $size, $width, $height);

    // save image
    if (!is_dir("thumbs"))
        mkdir("thumbs");
    imagejpeg($newImage, $thumbPath, 95);

    // output image
    setContentType('JPEG');
    imagejpeg($newImage, null, 95);
}


 #####
#     #  ####  #    #  ####  ##### #####  #    #  ####  #####
#       #    # ##   # #        #   #    # #    # #    #   #
#       #    # # #  #  ####    #   #    # #    # #        #
#       #    # #  # #      #   #   #####  #    # #        #
#     # #    # #   ## #    #   #   #   #  #    # #    #   #
 #####   ####  #    #  ####    #   #    #  ####   ####    #

function setContentType($ContentType) {
    switch($ContentType) {
        case 'XML':
            header('Content-Type: text/xml'); break;
        case 'MPEG':
            header('Content-Type: audio/mpeg'); break;
        case 'JPEG':
            header('Content-Type: image/jpeg'); break;
        case 'JSON':
            header('Content-Type: application/json'); break;
    }
}
function dictToXMLNode_legacy($nodeTag, $dict, $contents = null) {
    $dict = $dict===null?array():$dict;

    $newXML = "\n<$nodeTag";
    foreach ($dict as $key => $value) {
        $safeValue = safeXMLencode($value);
        $newXML .= " $key=\"$safeValue\"";
    }
    if ($contents===null) {
        $newXML .= "/>";
    } else {
        $newXML .= ">";
        $newXML .= str_replace("\n", "\n  ", $contents);
        $newXML .= "\n</$nodeTag>";
    }
    return $newXML;
}
function formatIndexesXML($indexes) {
    $response = new ResponseObject('indexes');

    // add letters to indexes
    foreach(array_keys($indexes) as $index) {
        $indexRes = new ResponseObject('index', array('name'=>$index));

        // add artists to index
        foreach($indexes[$index] as $artist) {
            $indexRes->addChild(new ResponseObject('artist', array
                ( 'name' => $artist['name']
                , 'id'   => intval($artist['id'])
                )));
        }
        $response->addChild($indexRes);
    }
    return $response;
}
function formatMusicDir($id, $folders, $files) {
    $response = new ResponseObject('directory', array('id' => $id));

    // add folder children
    foreach ($folders as $folder) {
        $response->addChild(new ResponseObject('child', array
            ( 'id'       => intval($folder['id'])
            , 'parent'   => intval($folder['parentid'])
            , 'title'    => $folder['name']
            , 'isDir'    => true
            , 'album'    => $folder['name']
            , 'artist'   => $folder['parentname']
            , 'coverArt' => intval($folder['id'])
            // , 'created'  => $folder['']
            )));
    }

    //add file children
    foreach ($files as $file) {
        $response->addChild(new ResponseObject('child', array
            ( 'id'          => intval($file['id'])
            , 'parent'      => intval($file['parentid'])
            , 'title'       => $file['title']
            , 'album'       => $file['album']
            , 'artist'      => $file['artist']
            , 'isDir'       => false
            , 'duration'    => floatval($file['duration'])
            , 'bitRate'     => floatval($file['bitrate'])
            , 'track'       => intval($file['track'])
            , 'size'        => intval($file['filesize'])
            , 'suffix'      => $file['fileextension']
            , 'contentType' => 'audio/mpeg'
            , 'isVideo'     => false
            , 'path'        => $file['relpath']
            , 'type'        => 'music'
            , 'coverArt'    => intval($file['parentid'])
            // , 'albumId'     => 
            // , 'artistId'    => 
            // , 'created'     => 
            )));
    }

    return $response;
}



 #####
#     #  ####    ##   #    # #    # # #    #  ####
#       #    #  #  #  ##   # ##   # # ##   # #    #
 #####  #      #    # # #  # # #  # # # #  # #
      # #      ###### #  # # #  # # # #  # # #  ###
#     # #    # #    # #   ## #   ## # #   ## #    #
 #####   ####  #    # #    # #    # # #    #  ####

function mp3lib() {
    static $getid3;
    if (isset($getid3)) {
        return $getid3;
    } else {
        require_once('GetID3/getid3.php');
        $getid3 = new getID3;
        $getid3->option_save_attachments = false;
        $getid3->option_tag_lyrics3 = false;
        set_time_limit(30);
        return $getid3;
    }
}

function getID3Data($filename) {
    $getid3 = mp3lib();
    $data = $getid3->analyze($filename);
    getid3_lib::CopyTagsToComments($data); 
    return $data;
}

function scanIndexes() {
    global $OPT_MUSICDIR;
    $topLevelFolders = getSubDirectories($OPT_MUSICDIR);
    $topLevelFoldersByLetter = splitByFirstLetter($topLevelFolders);
    dbWriteIndexes($topLevelFoldersByLetter);
    echo "done writing indexes!";
}

function getSubDirectories($parent) {
    $files = array();
    $folders = array();
    getDirContents($parent,$files,$folders);
    return $folders;
}
function getDirContents($parent, &$files, &$folders) {
    global $OPT_IGNOREDFOLDERS;
    // change the cwd to $parent
    $oldwd = getcwd();
    chdir($parent);

    $everything = scandir($parent);
    foreach ($everything as $item) {
        if (!in_array($item, $OPT_IGNOREDFOLDERS)) {
            if (is_dir($item)) {
                $folders[] = $item;
            } elseif (is_file($item)) {
                $files[] = $item;
            }
        }
    }

    // set the cwd back
    chdir($oldwd);
}

function scanAllFolders() {
    global $OPT_MUSICDIR;
    $indexes = dbReadIndexes();
    foreach($indexes as $id => $name) {
        $fullPath = $OPT_MUSICDIR.$name;
        if (is_dir($fullPath)) {
            dbBeginTrans();
            $containsMusic = scanFolder($fullPath, $id, $name, NULL);
            if (!$containsMusic) {
                dbDeleteIndex($id);
            }
            dbEndTrans();
        } else {
            dbDeleteIndex($id);
        }
    }    echo "done scanning folders!";

}

function scanFolder($parentPath, $parentId, $parentName, $grandParentName) {
    global $OPT_MUSICDIR;
    $containsMusic = false;

    $files = array(); $folders = array();
    getDirContents($parentPath,$files,$folders);

    foreach ($folders as $childName) {
        $childPath = "$parentPath/$childName";
        $dbChildId = dbCreateDirectory($childName, $parentId, $parentName, $childPath);

         if (scanFolder($childPath, $dbChildId, $childName, $parentName)) {
            $containsMusic = true;
        } else {
            dbDeleteDirectory($dbChildId);
        }
    }

    foreach ($files as $file) {
        if (isRightFileType($file)) {
            $filePath = "$parentPath/$file";
            $fileExtn = substr($file, strrpos($file, '.')+1);
            $relPath = substr($filePath, strlen($OPT_MUSICDIR));
            dbWriteTrackData($filePath, $file, $fileExtn, $parentId, $parentName, $grandParentName, $relPath);
            $containsMusic = true;
        }
    }

    return $containsMusic;
}

function isRightFileType($filename) {
    global $OPT_ACCEPTED_FILE_TYPES;
    foreach ($OPT_ACCEPTED_FILE_TYPES as $fileType) {
        if (endsWith($filename, $fileType))
            return true;
    }
    return false;
}

function scanMP3Info_First() {
    global $OPT_SCAN_COUNTPERREFRESH;
    dbBeginTrans();
    $mp3s = dbGetUnscannedTracks($OPT_SCAN_COUNTPERREFRESH);
    foreach($mp3s as $mp3) {
        $meta = getMP3Info($mp3);
        $meta = localize_GetID3_results($meta);
        dbUpdateTrackInfo($mp3, $meta);
    }
    dbEndTrans();
}

function getMP3Info($filename) {
    echo "<p>$filename</p>";
    return getID3Data($filename);
}

function legacy_getMP3Info($filename) {
    echo "$filename<br>";
    $all = array();
    $id3 = new ID3TagsReader();
    $id3 = $id3->getTagsInfoProgressive($filename);
    $meta = new mp3file($filename);
    $meta = $meta->get_metadata();

    apush('Title',  $id3, $all);
    apush('Album',  $id3, $all);
    apush('Author', $id3, $all);
    apush('Track',  $id3, $all);
    apush('Version', $id3, $all);
    apush('LengthID3', $id3, $all);

    apush('Filesize',      $meta, $all);
    apush('Encoding',      $meta, $all);
    apush('Bitrate',       $meta, $all);
    apush('Sampling Rate', $meta, $all);
    apush('Length',        $meta, $all);

    $all['DurationFinal'] = max(intornull($all['Length']), intornull($all['LengthID3']));
    $all['Track'] = intornull($all['Track']);

    return $all;
}







 #####
#     #  ####  #
#       #    # #
 #####  #    # #
      # #  # # #
#     # #   #  #
 #####   ### # ######

function dbConnect() {
    global $OPT_SQL_FILENAME;
    static $db;
    if (isset($db)) {
        return $db;
    } else {
        if (!file_exists($OPT_SQL_FILENAME)) {
            dbCreateTables();
        }
        if ($db = new PDO("sqlite:$OPT_SQL_FILENAME")) {
            return $db;
        } else {
            die(getTemplate('DBACCESSERROR'));
        }
    }
}

function dbBeginTrans() {
    $db = dbConnect();
    $db->beginTransaction();
}

function dbEndTrans() {
    $db = dbConnect();
    $db->commit();
}

function dbCancelTrans($sure = false) {
    if ($sure) {
        $db = dbConnect();
        $db->rollBack();
    }
}

function dbConnectSQLite3() {
    global $OPT_SQL_FILENAME;
    if ($db = new SQLite3($OPT_SQL_FILENAME)) {
        return $db;
    } else {
        die(getTemplate('DBACCESSERROR'));
    }
}

function dbCreateTables() {
    $db = dbConnectSQLite3();

    $db->exec('
        CREATE TABLE IF NOT EXISTS tblLibraries (
            id               INTEGER PRIMARY KEY AUTOINCREMENT,
            name             TEXT NOT NULL,
            dir              TEXT
        );'); echo "tblLibraries created.<br/>";
    $db->exec('
        CREATE TABLE IF NOT EXISTS tblIndexes (
            id               INTEGER PRIMARY KEY AUTOINCREMENT,
            name             TEXT NOT NULL UNIQUE,
            letterGroup      TEXT
        );'); echo "tblIndexes created.<br/>";
    $db->exec('
        CREATE TABLE IF NOT EXISTS tblDirectories (
            id               INTEGER PRIMARY KEY AUTOINCREMENT,
            name             TEXT NOT NULL,
            parentid         INTEGER,
            parentname       TEXT NOT NULL,
            fullpath         TEXT NOT NULL UNIQUE
        );

        DELETE FROM SQLITE_SEQUENCE WHERE name="tblDirectories";
        REPLACE INTO SQLITE_SEQUENCE (seq, name) VALUES (999999, "tblDirectories");

    '); echo "tblDirectories created.<br/>";
    $db->exec('
        CREATE TABLE IF NOT EXISTS tblTrackData (
            id               INTEGER PRIMARY KEY AUTOINCREMENT,
            parentid         INTEGER NOT NULL,
            parentname       TEXT,
            grandparentname  TEXT,
            title            TEXT,
            artist           TEXT,
            album            TEXT,
            track            INTEGER,
            trackint         INTEGER,
            duration         INTEGER,
            encoding         TEXT,
            bitrate          INTEGER,
            samplerate       INTEGER,
            filename         TEXT,
            relpath          TEXT,
            filesize         INTEGER,
            fileextension    TEXT,
            fullpath TEXT    UNIQUE,
            coverart         INTEGER,
            albumid          INTEGER,
            artistid         INTEGER,
            id3version       STRING,
            created          INTEGER
        );'); echo "tblTrackData created.<br/>";
    $db->exec('
        CREATE TABLE IF NOT EXISTS tblUsers (
            id               INTEGER PRIMARY KEY AUTOINCREMENT,
            username         TEXT NOT NULL UNIQUE,
            md5pass          TEXT NOT NULL
        );'); echo "tblUsers.<br/>";
    $db->exec('
        CREATE VIEW IF NOT EXISTS vwTracks as
            SELECT * FROM tblTrackData WHERE (
                    title IS NOT NULL
                AND filesize IS NOT NULL)
        ;'); echo "vwTracks created.<br/>";
    $db->exec('
        CREATE VIEW IF NOT EXISTS vwUnscannedTracks as
            SELECT * FROM tblTrackData WHERE (
                title IS NULL
                AND filesize IS NULL)
        ;'); echo "vwTracks created.<br/>";
    $db->close();
}


function dbWriteIndexes($indexes) {
    $db = dbConnect();
    $db->beginTransaction();
    foreach($indexes as $letter => $folders) {
        foreach($folders as $folder) {
            $q=$db->prepare('INSERT INTO tblIndexes (letterGroup, name) VALUES (?, ?);');
            $q->execute(array($letter, $folder));
        }
    }
    $db->commit();
}

function dbReadIndexes() {
    $db = dbConnect();
    $data = $db->query($sql = 'SELECT id, name FROM tblIndexes;');
    $result = array();
    foreach ($data as $row) {
        $id = $row['id'];
        $result[$id] = $row['name'];
    }
    return $result;
}

function dbCreateDirectory($childName, $parentId, $parentName, $childPath) {
    $db = dbConnect();
    $q=$db->prepare('INSERT INTO tblDirectories (name, parentid, parentname, fullpath) VALUES (?, ?, ?, ?);');

    $q->execute(array($childName, $parentId, $parentName, $childPath));
    return $db->lastInsertId();
}

function dbDeleteIndex($indexId) {
    $db = dbConnect();
    $q=$db->prepare('DELETE FROM tblIndexes WHERE id = ?;');
    $q->execute(array($indexId));
}

function dbDeleteDirectory($directoryId) {
    $db = dbConnect();
    $q=$db->prepare('DELETE FROM tblDirectories WHERE id = ?;');
    $q->execute(array($directoryId));
}

function dbWriteTrackData($filePath, $filename, $fileExtn, $parentId, $parentName, $grandParentName, $relPath) {
    $db = dbConnect();
    $q=$db->prepare('INSERT INTO tblTrackData
        ( fullpath
        , filename
        , fileextension
        , parentid
        , parentname
        , grandparentname
        , relpath
        ) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $q->execute(array($filePath, $filename, $fileExtn, $parentId, $parentName, $grandParentName, $relPath));
}

function dbGetUnscannedTracks($limit) {

    $db = dbConnect();
    $q=$db->prepare('SELECT COUNT(*) FROM vwUnscannedTracks;');
    $q->execute();
    $count = $q->fetch();
    $count = $count[0];
    echo "<p>Remaining: $count</p>";

    $q=$db->prepare('SELECT fullpath FROM vwUnscannedTracks LIMIT ?;');
    $q->execute(array($limit));
    $data=$q->fetchAll(PDO::FETCH_COLUMN, 0);
    return $data;
}

function dbUpdateTrackInfo($fullpath, $data) {
    $db = dbConnect();
    $q=$db->prepare('UPDATE tblTrackData SET title=?
                                           , album=?
                                           , artist=?
                                           , track=?
                                           , trackint=?
                                           , duration=?
                                           , id3version=?
                                           , encoding=?
                                           , bitrate=?
                                           , samplerate=?
                                           , filesize=?
                                             WHERE fullpath=?');
    $q->execute(array
        ( $data['Title']
        , $data['Album']
        , $data['Author']
        , $data['Track']
        , $data['TrackInt']
        , $data['DurationFinal']
        , $data['Version']
        , $data['Encoding']
        , $data['Bitrate']
        , $data['Sampling Rate']
        , $data['Filesize']
        , $fullpath
        ));
}

function dbGetIndexes() {
    $db = dbConnect();
    $q=$db->query('SELECT id, name, letterGroup FROM tblIndexes;');
    $data = $q->fetchAll();
    return $data;
}

function dbGetSubFolders($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT * FROM tblDirectories WHERE parentid=?;');
    $q->execute(array($id));
    $data = $q->fetchAll();
    return $data;
}

function dbGetSubFiles($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT * FROM vwTracks WHERE parentid=? ORDER BY trackint, filename');
    $q->execute(array($id));
    $data = $q->fetchAll();
    return $data;
}

function dbGetTrack($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT * FROM tblTrackData WHERE id=?');
    $q->execute(array($id));
    $data = $q->fetch();
    return $data;
}

function dbGetParentId($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT parentid FROM tblDirectories WHERE id=?');
    $q->execute(array($id));
    $data = $q->fetch();
    return $data[0];
}

function dbGetMP3filename($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT fullpath FROM tblTrackData WHERE id=?');
    $q->execute(array($id));
    $data = $q->fetchAll(PDO::FETCH_COLUMN, 0);
    return $data[0];
}

function dbGetFolderPath($id) {
    $db = dbConnect();
    $q=$db->prepare('SELECT fullpath FROM tblDirectories WHERE id=?');
    $q->execute(array($id));
    $data = $q->fetchAll(PDO::FETCH_COLUMN, 0);
    return $data[0];
}

function dbCheckUserPass($un, $pw) {
    $db = dbConnect();
    $q=$db->prepare('SELECT * FROM tblUsers WHERE username=? AND md5pass=?');
    $q->execute(array(
          $un
        , hash('md5', $pw)
    ));
    $data = $q->fetch(PDO::FETCH_COLUMN, 0);

    if ($data) return true;
    return false;
}






#     #
#     # ###### #      #####  ###### #####   ####
#     # #      #      #    # #      #    # #
####### #####  #      #    # #####  #    #  ####
#     # #      #      #####  #      #####       #
#     # #      #      #      #      #   #  #    #
#     # ###### ###### #      ###### #    #  ####

function rqst($key) {
    if (isset($_REQUEST[$key]))
        return $_REQUEST[$key];
    return null;
}
function endsWith($haystack, $needle) {
    return substr($haystack, -strlen($needle)) === $needle;
}
function startsWith($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}
function safeXMLencode($input) {
    if (getType($input) == 'string')
        return htmlentities($input, ENT_XML1 | ENT_COMPAT | ENT_SUBSTITUTE);
    return var_export($input, true);
}
function safeJSONencode($input) {
    if (getType($input) == 'string')
        return '"'.htmlentities($input, ENT_SUBSTITUTE).'"';
    return var_export($input, true);
}
function nonzero($input, $default) {
    $val = intval($input);
    return $val==0?$default:$val;
}
function getByMatch($keyLong, $array) {
    foreach($array as $key => $value) {
        if ($keyLong === $key)
            return $value;
    }
    return False;
}
function getByEndsWith($keyLong, $array) {
    foreach($array as $key => $value) {
        if (endsWith($keyLong, $key))
            return $value;
    }
    return False;
}
function removeArticles($word) {
    global $OPT_ARTICLES;
    foreach ($OPT_ARTICLES as $article) {
        if (startsWith($word, $article)) {
            $newWord = substr($word, strlen($article));
            $newWord = trim($newWord);
            if (strlen($newWord) != 0) {
                return $newWord;
            }
        }
    }
    return $word;
}
function strcontains($haystack, $needle) {
    return (strpos($haystack, $needle) !== false);
}
function getLetterGroup($name) {
    global $OPT_LETTERGROUPS, $OPT_NONALPHALETTERGROUP;
    $first = removeArticles($name);
    $first = strtoupper(substr($first, 0, 1));
    foreach($OPT_LETTERGROUPS as $lGroup) {
        if (strcontains($lGroup, $first)) {
            return $lGroup;
        }
    }
    return $OPT_NONALPHALETTERGROUP;
}
function removeTrailingSlash($path) {
    if (endsWith($path, '/'))
        return substr($path, 0, strlen($path)-1);
    return $path;
}
function splitByFirstLetter($items) {
    global $OPT_LETTERGROUPS, $OPT_IGNOREDFOLDERS;
    $splitItems = array();
    foreach($OPT_LETTERGROUPS as $lGroup) {
        $splitItems[$lGroup] = array();
    }
    foreach($items as $item) {
        if (!in_array($item, $OPT_IGNOREDFOLDERS)) {
            $lGroup = getLetterGroup($item);
            $splitItems[$lGroup][] = $item;
        }
    }
    return $splitItems;
}
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}
function splitIntoSubarrays($indexes) {
    $result = array();
    foreach($indexes as $index) {
        $letterGroup = $index['letterGroup'];
        if (!array_key_exists($letterGroup, $result)) {
            $result[$letterGroup] = array();
        }
        $result[$letterGroup][] = $index;
    }
    return $result;
}
function apush($key, $src, &$dest) {
    if (isset($src[$key]))
        $dest[$key] = $src[$key];
    else
        $dest[$key] = null;
}
function intornull($a) {
    if ($a == null)
        return null;
    return intval($a);
}

function localize_GetID3_results($data) {
    //TODO: deal with times when 'Title' etc are not present
    $new = array();
    $new['Title'] =               ¿($data, 'comments', 'title', 0);
    $new['Album'] =               ¿($data, 'comments', 'album', 0);
    $new['Author'] =              ¿($data, 'comments', 'artist', 0);
    $new['Track'] =               ¿($data, 'comments', 'track_number', 0);
    $new['DurationFinal'] = round(¿($data, 'playtime_seconds'));
    $new['Encoding'] =            ¿($data, 'audio', 'bitrate_mode');
    $new['Bitrate'] =       round(¿($data, 'audio', 'bitrate')/1000);
    $new['Sampling Rate'] =       ¿($data, 'audio', 'sample_rate');
    $new['Filesize'] =            ¿($data, 'filesize');

    //how we deal with 'version' is weird
    $new['Version'] =       isset($data['id3v2'])?2:(isset($data['id3v1'])?1:0);

    // this is an int version of the track number (for sorting)
    $new['TrackInt'] =     intval($new['Track']);
    return $new;
}

// [right-pointing double angle quotation mark] echos input, with newline, and replaces ' with "
function »($str) {
    echo "\n".»s($str);
}

// merely replaces ' with "
function »s($str) {
    return str_replace("'", '"', $str);
}

// [section sign] makes a string html-safe, for web rendering
function §($inp) {
    return htmlentities($inp, ENT_SUBSTITUTE);
}

// [1on2] zero-pads a number
function ½($s, $n=2) {
    return str_pad($s, $n, '0', STR_PAD_LEFT);
}

// [middle dot] does nothing!
function ·() {}

// [inverted question mark] is the greatest. You give it an array and a bunch of indexes,
// and it will return the appropriate item if it exists,
// otherwise it will return null
function ¿($arr) {
    $keys = func_get_args();
    
    for ($i=1; $i<count($keys); $i++) {
        $key = $keys[$i];
        if (!array_key_exists($key, $arr))
            return null;
        $arr = $arr[$key];
    }
    return $arr;
}

// this is similar to ¿, except it allows you to specify the default value
function ¿D($default, $arr) {
    $keys = func_get_args();
    
    for ($i=2; $i<count($keys); $i++) {
        $key = $keys[$i];
        if (!array_key_exists($key, $arr))
            return $default;
        $arr = $arr[$key];
    }
    return $arr;
}




###
 #  #    # # ##### #   ##   #
 #  ##   # #   #   #  #  #  #
 #  # #  # #   #   # #    # #
 #  #  # # #   #   # ###### #
 #  #   ## #   #   # #    # #
### #    # #   #   # #    # ######

processURI();


?>


