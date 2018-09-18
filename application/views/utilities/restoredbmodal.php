<div id="restoredbmodal" class="modal modal-fixed-footer modal-fixed-header">
  <div class="modal-header center-v-align">
      <?php echo headertxt(3, maticon('history', 'spaced-text').' Restore Database', 'class=" full-width center-align '.getcolorclass(5).'" id="restore-db-modal-header"'); ?>
  </div>
  <div class="modal-content center-v-align pscrollbar">
    <div class="row"></div>
    <div class="row full-width">
      <div class="col s12">
          <?php echo form_open_multipart('utilities/Database/restoredb', 'id="restorefileselform"');?>
            <?php echo dragdropfilechooserdocready('restoresqlfile', 'restoresqlfile', 'uploads/Uploads/uploadsqldbrestorefile', 'attach_file', 'sqlrestorefiler'); ?></br>
            <br><br>
            <hr class="style14"></br>

          <?php echo mdlsubmitbtn('autorenew', 'Restore Database', 'restoresqlsubmit', 'disabled'); ?>
          </form>
      </div>
    </div>
        
    </div>
    <div class="modal-footer grey lighten-2">
      <a href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat"><?php echo maticon('cancel', 'normal-text'); ?> Dismiss</a>
    </div>

    
</div>
<script>
$(document).ready(function(){
  $("#restoresqlsubmit").click(function(e){
    if ($(this).hasClass("disabled")) {
      e.preventDefault();
      alert('Please Choose SQL File to restore from');
    }

  });


});
</script>