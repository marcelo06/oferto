<div class="footer-container">
        
    <div class="footer-info">
        <div class="row clearfix facebook">
<? $empresa= empresa::get_contacto()?>
            <div class="grid_3">
                            <h4>Facebook</h4>
                            <? if($empresa['facebook']!=''){?>
                <div class="block-content">
                <iframe src="//www.facebook.com/plugins/likebox.php?href=<?=urldecode($empresa['facebook'])?>&amp;width=270&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                </div>
                <? }?>
                        </div>

           <div class="grid_3"> <? if($empresa['wtwitter']!='') {?>
            <h4> Twitter</h4>
                <?=$empresa['wtwitter']?>
                <script type="text/javascript">
jQuery("a.twitter-timeline").attr('data-chrome',"nofooter noborders transparent");
                </script>
                <? }?>
            </div>


                        <div class="grid_3 information">
	            <h4>Ubicaciones</h4>
<div class="block-content">
<a href="javascript:ver_mapa()"><img src="<?=URLVISTA?>skin/comercio/skin/images/map.png" /></a>
</div>
                        </div>
            
            <div class="grid_3">
	            <h4>Contacto</h4>
<div class="block-content">

<p><? if($empresa['telefono']!='' or $empresa['telefono2']!='' or $empresa['telefono3']!=''){
    echo 'Teléfono(s): ';
    if($empresa['telefono']!='')
        echo $empresa['telefono'];
    if($empresa['telefono2']!='')
        echo ' - '.$empresa['telefono2'];
    if($empresa['telefono3']!='')
        echo  ' - '.$empresa['telefono3'];
    echo '<br/>';
} ?>

<?=($empresa['movil']!='') ? 'Móvil: '.$empresa['movil'].'<br/>':''?>
<?=($empresa['direccion']!='') ? 'Dirección: '.$empresa['direccion'].'<br/>':''?>
<?=($empresa['skype']!='') ? 'Skype: <a href="skype:'.$empresa['skype'].'?chat">'.$empresa['skype'].'</a><br/>':''?>
</p>
<?=($empresa['email']!='') ? '<p><a href="mailto:'.$empresa['email'].'">'.$empresa['email'].'</a></p>':''?><hr />
<ul class="social">
<?=($empresa['twitter']!='') ? '<li><a class="twitter" href="'.$empresa['twitter'].'" target="social" title="Twitter"><span>Twitter</span></a></li>':''?>
<?=($empresa['facebook']!='') ? '<li><a class="facebook" href="'.$empresa['facebook'].'" target="social" title="Facebook"><span>Facebook</span></a></li>':''?>
<?=($empresa['email']!='') ? '<li><a class="email" href="'.$empresa['email'].'" title="Email"><span>Email</span></a></li>':''?>
<?=($empresa['youtube']!='') ? '<li><a class="youtube" href="'.$empresa['youtube'].'" target="social" title="Youtube"><span>Youtube</span></a></li>':''?>
<?=($empresa['linkedin']!='') ? '<li><a class="linkedin" href="'.$empresa['linkedin'].'" target="social" title="Linkedin"><span>Linkedin</span></a></li>':''?>

</ul>
</div> 
 </div>

        </div>
    </div>
        <footer class="row clearfix">
      
        <div class="grid_12">
            
<ul class="links">
	
	<li><a href="http://www.rhiss.net" target="_blank">Rhiss.net</a>  &copy; <?=date("Y")?></li>
</ul>
                        </div>
    </footer>
</div>
<? if(!empty($empresa['pa'])){ ?>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://oferto.co/stats/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?=$empresa['pa']?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://oferto.co/stats/piwik.php?idsite=<?=$empresa['pa']?>" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
<? } ?>