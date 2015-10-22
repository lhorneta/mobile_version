<?php

class Cart extends Controller {

    public $order;

    public function action_index($array) {
        $this->checkout($array);
    }

    final public function checkout($order) {

        foreach ($order as $item) {

            //	echo $key.'<br/>';

            foreach ($item as $key => $it) {
                echo "
                    <br/>" . $key . ":" . $it['id'] . "<br/>
                    <br/>" . $key . ":" . $it['name'] . "<br/>
                    <br/>" . $key . ":" . $it['description'] . "<br/>
                    <br/>" . $key . ":" . $it['image'] . "<br/>
                    <br/>" . $key . ":" . $it['price'] . "<br/>
                    <br/>" . $key . ":" . $it['count'] . "<br/>
                    <br/>" . $key . ":" . $it['sum'] . "<br/>
                    <br/>" . $key . ":" . $it['params'] . "<br/>
                ";
            }
        }
    }

}
