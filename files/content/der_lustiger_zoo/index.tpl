<div class="zooindex courier absatz">
    <div class="inner">
        <h1>Der lustiger Zoo - Die sch&ouml;nsten Tierfotos der Welt </h1>
        <div class="zoo">
            <img src="jetzt/der_lustiger_zoo/img/zoo.gif" alt='Eingang vom Der lustiger Zoo' />
            <div class="titel">
                <p><strong>Hallo Tierfreund! </strong> Tritt rein in die wundervolle Welt der Fauna. Ein Tier in Aktion zu sehen das kennen viele gar nicht mehr. In unserem "virtuellem" Zoo kannst Du alle Tiere auch mal streicheln. Wenn Du willst oder musst, dann kannst Du Dein Lieblingstier(e) auch "voten". Das bedeutet, Du kannst "voten", ne? Kapiert. Also, die Lieblingstiere. Dazu w&auml;hlst Du Dein Lieblingstier so lange aus, bis irgendwas passiert, in der IT-Fachsprache sprechen wir dann von Systemr&uuml;ckmeldung. Wenn das passiert, weine nicht, Du hast gerade Spa&szlig; und mal ehrlich, lieber Raucher: Hast Du dabei gerade an Deinen Glimmstengel gedacht? Nein! Die leckere Zigarette war komplett aus Deinem Gehirn verschwunden, der Geruch, der Geschmack. Siehst Du, so einfach ist es mit dem Rauchen aufzuh&ouml;ren. </p>
            </div>
        </div>        
    </div>
    <div id="NavTier">
        <ul>
            {{foreach name=tierlist key=tier item=el from=$arrRanking}}
            <li><a href="{{$el['link_zum_tier']}}" title="{{$el['kom']}}" class="{{$el['tier']}}"><span>{{$el['name']}}</span></a></li>
            {{/foreach}}
        </ul>
    </div>    
    <div style="clear:both;"></div>
</div>