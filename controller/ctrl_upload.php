<?php
// require_once "../model/connect.php";
require_once "../model/mdl_upload.php";

echo $date = date('Y-m-d');
$week = strtotime ($date);
echo '</br>Semaine : '.date('W',$week);


$_FILES['fichier']['name'];     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];     //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];     //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
$_FILES['fichier']['error'];    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.

$fullName = $_FILES['fichier']['name'];
$ext = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
$name = substr($_FILES['fichier']['name'], 0, -strlen($ext)-1 );
$fileSize = $_FILES['fichier']['size'];

$maxSize = 1048576;
// $maxWidth = 1200;
// $maxHeight = 700;

    echo '</br>';
    echo '<b>Nom brut : </b>'.$fullName.'</br>';
    echo '<b>Nom sans extension : </b>'.$name.'</br>';
    echo '<b>Extension : </b>'.$ext.'</br>';
    echo '<b>Taille en Octets : </b>'.$fileSize.'</br>';
    echo '</br>';
    
    if ($_FILES['fichier']['error'] > 0) $erreur = "Erreur lors du transfert";
    if ($_FILES['fichier']['size'] > $maxSize) $erreur = "Le fichier est trop gros";

    // $image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
    // if ($image_sizes[0] > $maxWidth OR $image_sizes[1] > $maxHeight) $erreur = "Image trop grande";
    
    
// Créer un identifiant difficile à deviner
$nom = md5(uniqid(rand(), true));

$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],'../cloud/' .$nom.'.'.$ext);

if ($resultat){ 
    echo "Transfert réussi </br>";
    $url = '../cloud/' .$nom.'.'.$ext;
};

// ===== ENVOI BDD =====
insertDB($name, $url, $date, $fileSize, $ext);

// ====== ENVOI MAIL =====

ini_set( 'display_errors', 1 );

error_reporting( E_ALL );

$from = "test.form@gmail.com";

$to = $_POST["destinataire"];

$subject = "Vérification PHP mail";


$message = "<html><head><title></title>
#outlook a {
      padding: 0;
    }

    .ReadMsgBody {
      width: 100%;
    }

    .ExternalClass {
      width: 100%;
    }

    .ExternalClass * {
      line-height: 100%;
    }

    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 13px 0;
    }
    @media only screen and (max-width:480px) {
      @-ms-viewport {
        width: 320px;
      }

      @viewport {
        width: 320px;
      }
    }
  
  
  
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
  
  
  
    @media only screen and (min-width:480px) {
      .mj-column-px-600 {
        width: 600px !important;
        max-width: 600px;
      }

      .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }

      .mj-column-px-400 {
        width: 400px !important;
        max-width: 400px;
      }
    }
  </style>
  
  </style>
</head>

<body>
  <div style>
   
    <div style=background:#318ce7;background-color:#318ce7;Margin:0px auto;max-width:600px;>
      <table align=center border=0 cellpadding=0 cellspacing=0 role=presentation style=background:#318ce7;background-color:#318ce7;width:100%;>
        <tbody>
          <tr>
            <td style=direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;>
         
              <div class=mj-column-px-600 outlook-group-fix style=font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;>
                <table border=0 cellpadding=0 cellspacing=0 role=presentation style=vertical-align:top;width=100%>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style=background:#fafafa;background-color:#fafafa;Margin:0px auto;max-width:600px;>
      <table align=center border=0 cellpadding=0 cellspacing=0 role=presentation style=background:#fafafa;background-color:#fafafa;width:100%;>
        <tbody>
          <tr>
            <td style=direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;>
              <div class=mj-column-per-100 outlook-group-fix style=font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;>
                <table border=0 cellpadding=0 cellspacing=0 role=presentation style=vertical-align:top; width=100%>
                  <tr>
                    <td align=center style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:20px;font-style:italic;line-height:1;text-align:center;color:#626262;> We transfer vous informes </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style=background:#fafafa;background-color:#fafafa;Margin:0px auto;max-width:600px;>
      <table align=center border=0 cellpadding=0 cellspacing=0 role=presentation style=background:#fafafa;background-color:#fafafa;width:100%;>
        <tbody>
          <tr>
            <td style=direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;>
              <div class=mj-column-px-400 outlook-group-fix style=font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;>
                <table border=0 cellpadding=0 cellspacing=0role=presentation style=vertical-align:top; width=100%>
                  <tr>
                    <td align=left style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Helvetica Neue;font-size:20px;font-style:italic;line-height:1;text-align:left;color:#626262;> Bonjour, </div>
                    </td>
                  </tr>
                  <tr>
                    <td align=left style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#525252;> Veuillez trouver ci joint le lien pour télécharger vos fichiers ou copier/coller le lien dans votre navigateur internet </div>
                    </td>
                  </tr>
                  <tr>
                    <td align=center vertical-align=middle style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <table border=0 cellpadding=0 cellspacing=0 role=presentation style=border-collapse:separate;line-height:100%;>
                        <tr>
                          <td align=center bgcolor=#318ce7 role=presentation style=border:none;border-radius:3px;cursor:auto;padding:10px 25px;background:#318ce7; valign=middle>
                            <a href=# style=background:#318ce7;color:#ffffff;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none; target=_blank> Lien de téléchargement </a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td align=center style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:10px;line-height:1;text-align:center;color:#000000;> https://www.sois-net.fr/mjml-framework-emails-responsive/ </div>
                    </td>
                  </tr>
                </table>
              </div>
      
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style=background:#fafafa;background-color:#fafafa;Margin:0px auto;max-width:600px;>
      <table align=center border=0 cellpadding=0 cellspacing=0 role=presentation style=background:#fafafa;background-color:#fafafa;width:100%;>
        <tbody>
          <tr>
            <td style=direction:ltr;font-size:0px;padding:20px 0;text-align:center;vertical-align:top;>
              <div class=mj-column-px-400 outlook-group-fix style=font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;>
                <table border=0 cellpadding=0 cellspacing=0 role=presentation style=vertical-align:top; width=100%>
                  <tr>
                    <td align=left style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Helvetica Neue;font-size:12px;line-height:1;text-align:left;color:#626262;> Nous vous remercions pour votre confiance </div>
                    </td>
                  </tr>
                  <tr>
                    <td align=left style=font-size:0px;padding:10px 25px;word-break:break-word;>
                      <div style=font-family:Helvetica Neue;font-size:10px;line-height:1;text-align:left;color:#525252;> Et ne vous inquiétez pas aucun de vos fichiers ou de vos données ne seront transférés à d'autre personnes , nous mettons tout en oeuvre pour vous protéger et sécurisé vos données </div>
                    </td>
                  </tr>
                </table>
              </div>
           </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>";


$passage_ligne = "\n";
$boundary = "-----=".md5(rand());
$header = "From: \"Moi-même\"<testdemail@mail.fr>".$passage_ligne;
$header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
$message = $passage_ligne."--".$boundary.$passage_ligne;
$message.= $passage_ligne."--".$boundary.$passage_ligne;
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

$header = "From:" . $from;

mail($to,$subject,$message, $header);

?>