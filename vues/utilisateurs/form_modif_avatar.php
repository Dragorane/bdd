<h2 class="center">Modification de votre avatar</h2>
<form action="<?= BASEURL ?>/index.php/valid_avatar" method="POST" enctype="multipart/form-data">
    <label for="photo">Avatar : </label>
    <input type="file" name="photo" id="photo"/><br/><br/>
    <input type="submit" name="submit"/>
</form>