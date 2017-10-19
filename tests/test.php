<?php
    require_once ('PHPUnit/Framework/TestCase.php');

    class SimpleElementTest extends PHPUnit_Framework_TestCase {
        public function constructElement($e) {
            $e->name = "p";
            $e->content = "test";
        }

        public function testSimpleElementFormatting() {
            $e = new SimpleElement();
            $e->name = "body";
            $this->assertEquals(
                '<body>',
                $e->render()
            );
        }

        public function testElementFormatting() {
            $e = new Element();
            $this->constructElement($e);
            $this->assertEquals(
                '<p>test</p>',
                $e->render()
            );
        }

        public function testBlockElementFormatting() {
            $b = new BlockElement();
            $b->element = new Element();
            $this->constructElement($b->element);
            $b->incIndent();
            $this->assertEquals(
                '    <p>test</p>
',
                $b->render()
            );
        }
    }
?>
