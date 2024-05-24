<?php 

class Blockchain{
    public $chain;
    private $difficulty;

    function __construct(){
        $this->chain = [];
        $this->difficulty = 4; 
        $this->createBlock(1, '0');
    }
    
    function createBlock($proof, $previousHash){
        $block = array(
            'index' => $this->get_chain_length() + 1,
            'timestamp' => time(),
            'proof' => $proof,
            'previousHash' => $previousHash
        );
        array_push($this->chain, $block);
        return $block;
    }
    
    function get_chain_length(){
        return count($this->chain);
    }

    function print_previous_block(){
        return $this->chain[$this->get_chain_length() - 1];
    }

    function hashBlock($block){
        return hash('sha256', json_encode($block));
    }

    function proof_of_work($previous_proof){
        $new_proof = 1;
        $check_proof = false;
        $needle = str_repeat("0", $this->difficulty);

        while($check_proof == false){
            $hash_operation = hash('sha256', ($new_proof**2 - $previous_proof**2));
            if(substr($hash_operation, 0, $this->difficulty) === $needle){
                $check_proof = true;
            } else {
                $new_proof++;
            }
        }

        return $new_proof;
    }
}

// Contoh penggunaan:
$blockchain = new Blockchain();
echo "Blok pertama: ";
print_r($blockchain->print_previous_block());

$new_proof = $blockchain->proof_of_work(1);
$blockchain->createBlock($new_proof, $blockchain->hashBlock($blockchain->print_previous_block()));

echo "Blok kedua: ";
print_r($blockchain->print_previous_block());

?>
