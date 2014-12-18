<h2 class="center">Modification de votre avatar</h2>
<div class='petit_form'>

    <form action="<?= BASEURL ?>/index.php/valid_avatar" method="POST" enctype="multipart/form-data">
        <label for="photo">Avatar : </label>
        <input type="file" name="photo" id="photo"/><br/><br/>
        <center><input type="submit" name="submit" class='submit'/></center>
    </form>
</div>