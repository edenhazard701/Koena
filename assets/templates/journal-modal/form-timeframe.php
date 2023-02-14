<form id="form-<?=$timeframeId?>" callback="SSTimeFrameReload($('#jTicket').val(),'<?=$timeframeId?>');" action="summary/changeSSTimeframe">
    <input id='upload1-<?=$timeframeId?>' type="file" accept=".png, .jpg, .jpeg" name="image" enctype="multipart/form-data" style='display:none;' onchange="$('#form-<?=$timeframeId?>').submit();">
    <input id='ticket-<?=$timeframeId?>' type="hidden" name="ticket_id" value="">
    <input type="hidden" name="timeframe" value="<?=$timeframeId?>">
</form>
<script> $("#form-<?=$timeframeId?>").submit(ajaxSubmit); </script>
