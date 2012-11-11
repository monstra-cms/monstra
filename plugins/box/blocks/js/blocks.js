function embedCodes(name) {
    $('#shortcode').html('{block get="'+name+'"}');
    $('#phpcode').html('&lt;?php echo Block::get("'+name+'"); ?&gt;');
    $('#embedCodes').modal();
}