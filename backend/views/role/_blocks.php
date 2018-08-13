<?php $this->beginBlock("node"); ?>
    <?php foreach ($model->getNodes() as $k => $v) : ?>
        <div class=""><?= $v->msg?>---<?= $v->url?></div>
    <?php endforeach; ?>
<?php $this->endBlock(); ?>