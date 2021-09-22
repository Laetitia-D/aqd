<?php

if (!defined('ABSPATH')){
    die;
}
?>
<div class="wrap">
    <h1>Liste d'email des producteurs et leurs catégories</h1>

    <h2>Ajouter un email</h2>

    <form action="?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&action=createTabProducersEmailsCat" method="post" class="form-example">
        <div class="form-table" role="presentation">
            <div>
                    <label for="name">Sélectionner le nom du producteur : </label><br />
                    <select name="name" id="name" required>
                        <?php
                        $aqd_pas = $this->aqd_get_child_producer_category_id();
                        foreach ( $aqd_pas as $aqd_pa) {
                            echo '<option value="' .$aqd_pa->name . '">' . $aqd_pa->name . '</option>';
                        }
                        ?>
                    </select>
            </div>
            <div>
                    <label for="email">email: </label><br />
                    <input type="email" name="email" id="email" maxlength="32" required>
            </div>
            <div>
                    <label for="term_id">Sélectionner la catégorie: </label><br />
                    <select name="term_id" id="term_id" required>
                        <?php
                        $aqd_ps = $this->aqd_get_child_producer_category_id();
                        foreach ( $aqd_ps as $aqd_p) {
                            echo '<option value="' .$aqd_p->term_id . '">' . $aqd_p->name . '</option>';
                        }
                        ?>
                    </select>
        </div>
        <p class="submit">
            <input type="submit" id="Enregistrer" value="Enregistrer" class="button button-primary">
        </p>
    </form>


<div id="menupromail">
    <div id="active">
<div id="tableau">
    <div class="cfirst">
        <div class="left id">id</div>
        <div class="left nom">nom</div>
        <div class="left mail">mail</div>
        <div class="left cat">term_id</div>
        <div class="left delete">supprimer</div>
    </div>
    <?php

    $tab_prod_email_lists = $this->getData_aqd_producers();

    if (!empty($tab_prod_email_lists)) {
    foreach ($tab_prod_email_lists as $tab_prod_email_list) {
            ?>
            <div class="btop" id="<?php echo $tab_prod_email_list->id ?>">
                <div class="left id">
                    <?php echo $tab_prod_email_list->id ?>
                </div>
                <div class="left nom">
                    <?php echo "<div><a href=\"?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&p=produceremail&id=" . $tab_prod_email_list->id . "\">" . $tab_prod_email_list->name . "</a></div>" ?>
                </div>
                <div class="left mail">
                    <?php echo $tab_prod_email_list->email ?>
                </div>
                <div class="left cat">
                    <?php echo $tab_prod_email_list->term_id ?>
                </div>
                <div class="left delete" style="padding:7px 10px 0px 10px;">
                    <img src="<?php echo plugins_url( 'images/delete.jpg', __FILE__); ?>"
                         alt="supprimer" title="delete" />
                    <div class="loader"></div>
                </div>
            </div>
        <?php } ?>

    <?php }else{ ?>
        <div class="btop no-suscribers">Personne n'est enregistré</div>
    <?php } ?>
</div>
</div>
</div>
