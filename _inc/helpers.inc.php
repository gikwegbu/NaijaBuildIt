<?php



function htmOut($text){

echo htmlspecialchars($text,ENT_QUOTES, 'UTF-8') ;
}


function htmlOut($text){

htmlspecialchars($text,ENT_QUOTES, 'UTF-8') ;
}

function markdown2html($text)
{
  
  
 
  
  
  $text =  str_replace("<", '&lt;', $text); 
    $text =  str_replace(">", '&gt;', $text); 
    // Paragraphs
  $text = '<p>' . preg_replace('/\n\n/', '</p><p>', $text) . '</p>';
 //Line breaks
 $text = preg_replace('/\n/', '<br>', $text);
 
  
  return $text;
}

function markdownout($text)
{
  htmOut(markdown2html($text));
}