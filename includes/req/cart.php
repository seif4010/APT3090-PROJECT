<?php

class cart
{

    function getFileName()
    {
        return "cart.txt";
    }

    function addToCart($drug_id, $name, $expiry, $presp, $price, $qty)
    {
        try {
            $handle = fopen($this->getFileName(), "a+") or die("file Not Found");
            $exits = false;
            $data = file($this->getFileName());
            foreach ($data as $line) {
                if (preg_match("/{$name}/i", $line)) {
                    $exits = true;
                }
            }
            if ($exits) :
                return "Item Already On cart";
            else :
                return $this->writeToFile($handle, $this->buildString($drug_id, $name, $expiry, $price, $presp, $qty));
            endif;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function writeToFile($handle, $string)
    {
        fwrite($handle, "\r\n" . trim($string));
        $this->closeFile($handle);
        return "success";
    }

    function buildString($id, $name, $presp, $exp, $price, $qty)
    {
        return "$id" . "," . "$name" . "," . "$presp" . "," . "$exp" . "," . "$price" . "," . "$qty";
    }


    function openFileRead($filename)
    {
        return fread(fopen($filename, "r"), 100000000);
    }

    function closeFile($file)
    {
        fclose($file);
    }

    function truncateFile($file)
    {
        return fopen($file, "w");
    }

    function getCart($filename)
    {
        $pointer = $this->openFileRead($filename);

        $firstExplode = explode("\r\n", $pointer);
        $result = [];
        foreach ($firstExplode as $key => $value) {
            $result[] = explode(',', $value);
        }
        return $result;
    }

    function removeFromCart($id, $name, $expiry, $prep, $price, $qty)
    {
        $delete = $this->buildString($id, $name, $expiry, $prep, $price, $qty);
        try {
            $data = file($this->getFileName());
            $out = array();
            foreach ($data as $line) {
                if (trim($line) != $delete) {
                    $out[]  = trim($line);
                }
            }
            unlink($this->getFileName());
            $fp = fopen($this->getFileName(), "w+");
            flock($fp, LOCK_EX);
            if ($out != null) :
                foreach ($out as $line) {
                    fwrite($fp, trim($line) . "\r\n");
                }
            endif;
            flock($fp, LOCK_UN);
            fclose($fp);
            return "success";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function deleteCart()
    {
        unlink($this->getFileName());
        fopen($this->getFileName(), "w+");
        return "success";
    }
}
