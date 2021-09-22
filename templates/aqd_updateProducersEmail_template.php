<?php

if (!defined('ABSPATH')){
    die;
}
?>
<div class="wrap">
    <h1>Liste d'email des producteurs et leurs catégories</h1>


</div>

<div id="menupromail">
    <ul id="nav">
        <li><a href="?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php">Ajouter un e-mail</a></li>
        <?php

        $tab_prod_cat=$this->getData_aqd_producers();
        foreach($tab_prod_cat as $prom) {
            if ($_GET['id'] == $prom->id) $active = " id=\"active\" ";
            else $active = "";
            echo "<li " . $active . "><a href=\"?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&p=produceremail&id=" . $prom->id . "\">" . $prom->name . "</a></li>";
        }
        ?>
    </ul>
</div>

<h1>Modifier un e-mail</h1>

<form action="?page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&action=updateTabProducersEmailsCat" method="post" class="form-example">
    <div>
        <label for="name">Sélectionner le nom du producteur : </label><br />
        <select name="name" id="name" value="<?php echo $prom->name ?>" required>
            <?php
            $aqd_pas = $this->aqd_get_child_producer_category_id();
            foreach ( $aqd_pas as $aqd_pa) {
                echo '<option value="' . $aqd_pa->name . '">' . $aqd_pa->name . '</option>';
            }
            ?>
        </select>
    </div>
    <div>
        <label for="email">email: </label><br />
        <input type="email" name="email" id="email" value="<?php echo $prom->email ?>" required>
    </div>
    <div>
        <label for="term_id">Sélectionner la catégorie: </label><br />
        <select name="term_id" id="term_id" value="<?php echo $prom->term_id ?>" required>
            <?php
            $aqd_ps = $this->aqd_get_child_producer_category_id();
            foreach ( $aqd_ps as $aqd_p) {
                echo '<option value="' .$aqd_p->term_id . '">' . $aqd_p->name . '</option>';
            }
            ?>
        </select>
    </div>
    <input type="hidden" name="id" value="<?php echo $prom->id ?>" />
    <p class="submit">
        <input type="submit" value="Mettre à jour" class="button button-primary">
    </p>
</form>

<form action="??page=awesome_quotations_dispatcher/awesome_quotations_dispatcher.php&action=deleteTabProducersEmailsCat" method="post">
    <p>
        <input type="hidden" name="id" value="<?php echo $prom->id ?>" />
    </p>
    <p>
        <input type="submit" class="button button-primary" id="Supprimer"
               value="Supprimer" />
    </p>
</form>
