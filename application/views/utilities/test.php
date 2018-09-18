<div class="row full-width">
      <div class="col s12">
          <?php echo form_open_multipart('uploads/Uploads/uploadattachments/testupload/2', 'id="restorefileselform"');?>
            
            <br><br>
            <hr class="style14"></br>
            <input type="file" name="testupload"  accept="xls, xlsx, csv" max="20" multiple/>
          <?php echo mdlsubmitbtn('autorenew', 'Test Upload', 'restoresqlsubmit'); ?>
          </form>
      </div>
    </div>