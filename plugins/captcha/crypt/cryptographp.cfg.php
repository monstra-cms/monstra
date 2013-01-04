<?php

// -------------------------------------
// General config
// -------------------------------------

$cryptwidth  = 130;  // Crypt image width (pixels)
$cryptheight = 40;   // Crypt image height (pixels)

$bgR  = 255;         // Background color RGB: Red (0 - 255)
$bgG  = 255;         // Background color RGB: Green (0 - 255)
$bgB  = 255;         // Background color RGB: Blue (0 - 255)

$bgclear = true;     // Background transparent (true/false)
$bgimg   = '';       // Background image
$bgframe = true;     // Image frame/border

// ----------------------------
// Characters config
// ----------------------------

$charR = 0;     // Characters color RGB: Red (0 - 255)
$charG = 0;     // Characters color RGB: Green (0 - 255)
$charB = 0;     // Characters color RGB: Blue (0 - 255)

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

$charanglemax  = 25;     // The maximum steering angle of characters (0 - 360)
$charup   = true;        // Vertical movement of random characters (yes / no)

// Additional effects

$cryptgaussianblur = false; // Gaussian Blur
$cryptgrayscal = false;     // Grayscal

// ----------------------
// Configuration du bruit
// ----------------------

$noisepxmin = 10;      // Noise: The minimum number of random pixels
$noisepxmax = 10;      // Noise: The maximum number of random pixels

$noiselinemin = 1;     // Noise: The minimum number of random lines
$noiselinemax = 1;     // Noise: The maximum number of random lines

$nbcirclemin = 1;      // Noise: The minimum random circles
$nbcirclemax = 1;      // Noise: The maximum random circles

$noisecolorchar  = 3;  // Noise: pixel colors, lines, circles: (1 - 3)
                       // 1: Characters color
                       // 2: The background color
                       // 3: Random Color

$brushsize = 1;        // Brush size (in pixels) (1 - 25)

$noiseup = false;      // Noise is under entry (TRUE) or below (false)

// --------------------------------
// System configuration and security
// --------------------------------

$cryptformat = "png";   // Image format "GIF", "PNG" or "JPG"
$cryptsecure = "md5";   // Crypt method "md5", "sha1" or ""
$cryptusetimer = 0;     // Time sleep
$cryptusertimererror = 3;  // Min times
$cryptusemax = 1000;     // Max times
$cryptoneuse = false;    //
