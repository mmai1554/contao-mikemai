<div class="ranking">
<h2>Die Lustiger Zoo Bestenliste (Stand: heute)</h2>
<table>
    {{foreach item=el key=tier from=$arrRanking}}
    <tr>
        <td class="col_0">{{$el['name']}}:</td>
        <td><div class="ranky" style="width:{{$el['width']}}px" ></div></td>
        <td>{{$el['votes']}} Stimmen
            {{if $el['more_votes']}}
            <div style="font-size:60%;color:"><a href="{{$el['link_zum_tier']}}" title="Dieses Tier braucht Ihre Stimme!">Oh Nein! Bitte wählen...</a></div>
            {{/if}}
        </td>
    </tr>
    {{/foreach}}
</table>
</div>


