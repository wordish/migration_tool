<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="ccm-dashboard-header-buttons btn-group">
    <a href="<?=$view->action('view_batch', $batch->getID())?>" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t('Batch to Batch')?></a>
    <button data-dialog="delete-files" type="button" data-dialog-title="<?=t('Delete Files')?>" class="btn btn-danger"><?=t('Delete Files')?></button>
    <span data-upload-action="<?=$view->action('upload_files')?>" class="fileinput-button btn btn-primary">
        <input style="visibility: hidden" type="file" name="file" multiple />
        <span><?=t('Upload Files')?></span>
    </span>
</div>

<div style="display: none">

    <div id="ccm-dialog-delete-files" class="ccm-ui">
        <form method="post" action="<?=$view->action('delete_files')?>">
            <?=Loader::helper("validation/token")->output('delete_files')?>
            <input type="hidden" name="id" value="<?=$batch->getID()?>">
            <p><?=t('Are you sure you remove all the files from this batch? They will be deleted from the entire concrete5 site. This cannot be undone.')?></p>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-files form').submit()"><?=t('Clear Batch')?></button>
            </div>
        </form>
    </div>

</div>

<h2><?=t('Batch')?>
    <small><?=$batch->getDate()->format('F d, Y g:i a')?></small></h2>

<? if (count($files)) { ?>


    <table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th><?=t('Type')?></th>
        <th style="width: 100%"><?=t('Filename')?></th>
    </tr>
    </thead>
    <tbody>
    <? foreach($files as $file) { ?>
        <tr>
            <td><?=$file->getListingThumbnailImage()?></td>
            <td><?=$file->getType()?></td>
            <td><?=$file->getFilename()?></td>
        </tr>
    <? } ?>
    </table>

<? } else { ?>
    <p><?=t('No files have been added to this batch.')?></p>
<? } ?>

<script type="text/javascript">

$(function() {
    $('[data-dialog]').on('click', function() {
        var element = '#ccm-dialog-' + $(this).attr('data-dialog');
        jQuery.fn.dialog.open({
            element: element,
            modal: true,
            width: 320,
            title: $(this).attr('data-dialog-title'),
            height: 'auto'
        });
    });
    var $uploader = $('span[data-upload-action]'),
        uploadAction = $uploader.attr('data-upload-action'),
        files = [], errors = [];

    $uploader.fileupload({
        url: uploadAction,
        dataType: 'json',
        formData: {
            'ccm_token': '<?=Core::make("token")->generate("upload_files")?>',
            'id': '<?=$batch->getID()?>'
        },
        error: function(r) {
            var message = r.responseText;
            try {
                message = jQuery.parseJSON(message).errors;
                _(message).each(function(error) {
                    errors.push({ name:name, error:error });
                });
            } catch (e) {
                ConcreteAlert.dialog('<?=t('Error')?>', r.statusText);
            }
        },
        start: function() {
            $uploader.find('span').html('<?=t('Uploading')?> <i class="fa fa-spin fa-refresh"></i>');
            $uploader.addClass('disabled');
            errors = [];
        },
        done: function(e, data)
        {
            files.push(data.result.files[0]);
        },
        stop: function() {

            $uploader.find('span').html('<?=t('Upload Files')?>');
            $uploader.removeClass('disabled');
            if (errors.length) {
                var str = '';
                $.each(errors, function(i, o) {
                    str += o.error + "\n";
                });
                ConcreteAlert.dialog('<?=t('Error')?>', str);

            } else {
                window.location.reload();
                files = [];
            }
        }
    });
});
</script>

<style type="text/css">

    .fileinput-button {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .fileinput-button input {
        position: absolute;
        top: 0;
        right: 0;
        visibility: visible !important;
        margin: 0;
        opacity: 0;
        -ms-filter: 'alpha(opacity=0)';
        font-size: 200px;
        direction: ltr;
        cursor: pointer;
    }

</style>