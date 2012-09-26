<?php

// -------------------------------------
// General config
// -------------------------------------

$cryptwidth  = 130;  // Crypt image width (pixels)
$cryptheight = 40;   // Crypt image height (pixels)

$bgR  = 255;         // Background color RGB: Red (0->255)
$bgG  = 255;         // Background color RGB: Green (0->255)
$bgB  = 255;         // Background color RGB: Blue (0->255)

$bgclear = true;     // Background transparent (true/false)
$bgimg   = '';       // Background image  
$bgframe = true;     // Image frame/border

// ----------------------------
// Characters config
// ----------------------------

$charR = 0;     // Characters color RGB: Red (0->255)
$charG = 0;     // Characters color RGB: Green (0->255)
$charB = 0;     // Characters color RGB: Blue (0->255)

$charcolorrnd = false;     // Random colors
$charcolorrndlevel = 2;    // Brightness level (0 - 4)
$charclear = 10;           // Intensity of characters transparency (0 - 127)

// Fonts
$tfont[] = 'luggerbu.ttf';
//$tfont[] = 'other ttf fonts';

$charel = 'ABCDEFGHKLMNPRTWXYZ234569'; // Characters to use

$crypteasy = true;       // Crypt image easy to read (true) or not (false)                         

$charelc = 'BCDFGHKLMNPRTVWXZ';   //  $crypteasy = true
$charelv = 'AEIOUY';              //  $crypteasy = true

$difuplow = false;      

$charnbmin = 4;         // Minimum characters in the ciphertext
$charnbmax = 4;         // Maximum characters in the ciphertext

$charspace = 20;        // Character spacing (in pixels)
$charsizemin = 14;      // The minimum size of the characters
$charsizemax = 16;      // The maximum size of the characters

$charanglemax  = 25;     // The maximum steering angle of characters (0-360)
$charup   = true;        // Vertical movement of random characters (yes / no)

// Additional effects

$cryptgaussianblur = false; // Transforme l'image finale en brouillant: m?thode Gauss (true/false)
                            // uniquement si PHP >= 5.0.0
$cryptgrayscal = false;     // Transforme l'image finale en d?grad? de gris (true/false)
                            // uniquement si PHP >= 5.0.0

// ----------------------
// Configuration du bruit
// ----------------------

$noisepxmin = 10;      // Bruit: Nb minimum de pixels al?atoires
$noisepxmax = 10;      // Bruit: Nb maximum de pixels al?atoires

$noiselinemin = 1;     // Bruit: Nb minimum de lignes al?atoires
$noiselinemax = 1;     // Bruit: Nb maximum de lignes al?atoires

$nbcirclemin = 1;      // Bruit: Nb minimum de cercles al?atoires 
$nbcirclemax = 1;      // Bruit: Nb maximim de cercles al?atoires

$noisecolorchar  = 3;  // Bruit: Couleur d'ecriture des pixels, lignes, cercles: 
                       // 1: Couleur d'?criture des caract?res
                       // 2: Couleur du fond
                       // 3: Couleur al?atoire
                       
$brushsize = 1;        // Taille d'ecriture du princeaiu (en pixels) 
                       // de 1 ? 25 (les valeurs plus importantes peuvent provoquer un 
                       // Internal Server Error sur certaines versions de PHP/GD)
                       // Ne fonctionne pas sur les anciennes configurations PHP/GD

$noiseup = false;      // Le bruit est-il par dessus l'ecriture (true) ou en dessous (false) 

// --------------------------------
// Configuration syst?me & s?curit?
// --------------------------------

$cryptformat = "png";   // Format du fichier image g?n?r? "GIF", "PNG" ou "JPG"
				                // Si vous souhaitez un fond transparent, utilisez "PNG" (et non "GIF")
				                // Attention certaines versions de la bibliotheque GD ne gerent pas GIF !!!

$cryptsecure = "md5";    // M?thode de crytpage utilis?e: "md5", "sha1" ou "" (aucune)
                         // "sha1" seulement si PHP>=4.2.0
                         // Si aucune m?thode n'est indiqu?e, le code du cyptogramme est stock? 
                         // en clair dans la session.
                       
$cryptusetimer = 0;        // Temps (en seconde) avant d'avoir le droit de reg?n?rer un cryptogramme

$cryptusertimererror = 3;  // Action ? r?aliser si le temps minimum n'est pas respect?:
                           // 1: Ne rien faire, ne pas renvoyer d'image.
                           // 2: L'image renvoy?e est "images/erreur2.png" (vous pouvez la modifier)
                           // 3: Le script se met en pause le temps correspondant (attention au timeout
                           //    par d?faut qui coupe les scripts PHP au bout de 30 secondes)
                           //    voir la variable "max_execution_time" de votre configuration PHP

$cryptusemax = 1000;  // Nb maximum de fois que l'utilisateur peut g?n?rer le cryptogramme
                      // Si d?passement, l'image renvoy?e est "images/erreur1.png"
                      // PS: Par d?faut, la dur?e d'une session PHP est de 180 mn, sauf si 
                      // l'hebergeur ou le d?veloppeur du site en ont d?cid? autrement... 
                      // Cette limite est effective pour toute la dur?e de la session. 
                      
$cryptoneuse = false;  // Si vous souhaitez que la page de verification ne valide qu'une seule 
                       // fois la saisie en cas de rechargement de la page indiquer "true".
                       // Sinon, le rechargement de la page confirmera toujours la saisie.