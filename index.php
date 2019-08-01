<?
require_once('constantes.php'); // arquivo para salvar constantes
require_once('DB.php'); // conexão com banco e metodos para inserir, editar, listar e excluir dados do banco

echo NOME; // printando uma constante
echo '<hr>';

$db = new DB; // instanciando a classe do banco que incluimos na 3ª linha atribuindo a variavel $db
$db->_tabela = 'teste'; //setando a tabela na qual vamos executar operações do banco

echo "<pre>";
print_r($db->read()); // listando todos os dados da tabela que escolhemos acima (select)
exit;
echo '<hr>';

print_r($db->read($where = "status='1'")); // listando todos os dados da tabela que escolhemos acima (select) porem apenas os que estiverem com status = 1 (where)
exit;
echo '<hr>';

$db->insert(['name' => 'pessego']); // inserindo apenas 1 linha na tabela

$dados = [ // aqui criamos a variavel $dados e atribuimos a ela um array com 3 arrays de dados dentro (que devemos passar o nome da coluna e o dado a ser inserido)
    ['name' => 'uva'],
    ['name' => 'abacate', 'status' => '0'],
    ['name' => 'laranja'],
];

foreach ($dados as $key => $value) { // e aqui percorremos o array $dados para inserir no banco mais de 1 registro
    $id = $db->insert($value); // se vc verificar na classe DB, o método insert retorna o id do dado que acabou de ser inserido, portanto, a variavel $id está recebendo esse retorno da linha inserida no banco
    if ($id) {
        echo 'O id do dado inserido é: ' . $id . '<hr>'; // aqui printamos uma mensagem com os ids das frutas inseridas
    }
}
print_r($db->read()); // aqui apenas trazemos todos os dados da tabelae scolhida após as inserções feitas anteriormente
echo '<hr>';
exit;

$db->update(['name' => 'galo-pera', 'status' => 1], "id=4"); // aqui fazemos o update, alteramos o nome da fruta e seu status
print_r($db->read($where = "name='galo-pera'")); //e fazemos uma busca pelo item alterado (a condição poderia ser $where = "id='4'"), traria o mesmo registro
echo '<hr>';
exit;

$db->delete("name='galo-pera'"); // pro delete vc só precisa passar a condição, no caso, estamos excluindo todos os registros da tabela que o name = galo-pera
$db->delete("id=6"); // excluindo o registro de id 6
$db->delete("status=0"); // excluindo registros que status = zero
print_r($db->read($where = "name='galo-pera'")); //e fazemos uma busca pelo item alterado (a condição poderia ser $where = "id='4'"), traria o mesmo registro




// CREATE TABLE `victor`.`teste` (`id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(45) NOT NULL, `status` TINYINT(1) NOT NULL DEFAULT 1, PRIMARY KEY (`id`));

// INSERT INTO `victor`.`teste` (`name`) VALUES ('abacaxi');
// INSERT INTO `victor`.`teste` (`name`, `status`) VALUES ('caju', 0);
// INSERT INTO `victor`.`teste` (`name`) VALUES ('banana');
// INSERT INTO `victor`.`teste` (`name`, `status`) VALUES ('pera', 0);
