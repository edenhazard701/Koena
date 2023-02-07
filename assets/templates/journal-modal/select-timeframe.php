<ul class="list-group list-group-flush <?php echo '$tmclass';?>" style="<?php echo '$style';?>">
    <div id='block-<?=$timeframeId?>' class="timeframeId-wrap">
    <li class="list-group list-group-flush">
        <div class='image-wrapper' >
            <a id="container-<?=$timeframeId?>" class="fancybox" rel="editor-808273962-gallery-1" href="#" data-size="1920x1080" gal-index="<?=$timeframeId?>">
                <img class='fancybox' id="ava-<?=$timeframeId?>">
            </a>
        </div>
    </li>
    <div style="width: 100%; display: inline-flex; justify-content: space-between; padding-top: 0.5rem;">
        <span class="material-icons colorGreen btn btn-primary" onclick="$('#upload1-<?=$timeframeId?>').click();"><i class="ion-android-upload"></i></span>
        <button type="button" class="btn btn-danger deleteTimeframe" id="deleteTimeframe1-<?=$timeframeId?>" data-timeframe="<?=$timeframeId?>" ><i class="ion-trash-a" style="font-size: 25px;"></i></button>
    </div>
    </div>
</ul>