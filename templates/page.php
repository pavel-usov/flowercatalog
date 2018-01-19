<!doctype html>
<?php
    $this->addPageHeader();
    $body = $this->addPageBody();

    $h = $Page->tblOfContent->newHeader('My Favorite Flowers Catalog');
    $body->addElement($h);

    $g = new BlockGroup();
    $fh = $h->newHeader('Flower: Jasmin');
    $g->addElement($fh);
    $g->addElement(new Image('jasmin.jpg'));
    $g->addElement($fh->newHeader("Description:"));
    $txt = '*Jasminum officinale* is a vigorous, twining, deciduous climber with sharply pointed pinnate leaves and clusters of starry, pure white flowers in summer, which are the source of its heady scent.';
    $g->addElement(new Text($txt));
    $g->addElement($fh->newHeader('Rating:'));
    $f = new Form();
    for ($i = 1; $i < 6; $i ++) {
        $r = $f->addRadio('jasmin', $i, new Text($i));
        $r->newline = false;
    }
    $r->setOption('checked');
    $f->addSubmitButton('Send');
    $g->addElement($f);
    $body->addElement($g);
?>
