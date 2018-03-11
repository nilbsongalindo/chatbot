<?php

$perg = ['O que é o BB Code?','Após habilitar, quando utilizarei o BB Code?','Quais as vantagens do BB Code?','Como faço para habilitar o BB Code?','Preciso ter internet no smartphone para usar o BB Code?','Tenho duas contas, preciso habilitar o BB Code duas vezes?','Sou segundo titular na conta, preciso utilizar o BB Code se o primeiro titular habilitar?','Como posso cancelar o BB Code?','Perdi o smartphone onde o BB Code está habilitado, corro risco de acessarem minha conta?','Troquei de smartphone, preciso fazer algo referente ao BB Code?','Tenho mais de um smartphone, posso usar BB Code nos dois?','Meus limites mudam usando BB Code?','Preciso liberar meu smartphone para utilizar o BB Code?','Moro no exterior, como eu faço para habilitar o BB Code?','O que é Biometria?','Quando uso a Biometria?','Quais as vantagens de usar Biometria?','Como eu cadastro a Biometria?','Se usar a biometria, preciso do cartão?','Tenho problemas com a digital, como eu faço em relação ao uso da Biometria?','A Biometria será solicitada todas as vezes que utilizar os terminais eletrônicos?','Sou segundo titular da conta, preciso cadastrar a Biometria?','Sou procurador de uma conta, devo usar a Biometria?','Um dedo de silicone com a minha digital irá acessar minha conta em um terminal com Biometria?','Meus limites mudam com a Biometria?','Porque preciso liberar meu celular ou computador?','Como faço para liberar meu celular ou tablet?','Se trocar ou formatar o celular eu preciso liberar novamente?','Posso movimentar minha conta por mais de um celular?','Como faço para liberar meu computador?','Se trocar ou formatar o computador eu preciso liberar novamente?','Posso movimentar minha conta por mais de um computador?','Se eu trocar o sistema operacional eu preciso liberar novamente?','Posso liberar meu computador ou celular sem ir até agência ou terminal?','Posso acessar minha conta sem liberar o celular ou computador?','Eu tenho BB Code, preciso liberar o computador?','Meus limites são os mesmos em equipamentos liberados e não liberados?','Perdi ou Vendi meu celular/ ou tablet, o que devo fazer?','O que são limites de movimentação?','Onde consulto meus limites?','Como posso aumentar meus limites?','Até quanto posso aumentar meus limites?','Posso aumentar o limite temporariamente?','Os limites são iguais na internet, celular e terminais?','Quais os limites após as 22h e até às 6h da manhã?','Nos finais de semana os limites são iguais?','Qual o limite no terminal do Banco24Horas?','Sou segundo titular, tenho os mesmos limites que o primeiro titular?','Moro no exterior, como posso alterar meus limites?','Quais as credenciais usadas para acesso no autoatendimento do Banco do Brasil?','Quais senhas uso no autoatendimento do Banco na internet?','Quais as senhas usadas para acesso no autoatendimento do Banco do Brasil?','Quais senhas uso nos terminais eletrônicos do Banco?','Quais senhas uso no autoatendimento do Banco na central de atendimento pelo telefone?','Como posso desbloquear minha senha?','Moro no exterior e bloqueei minha senha, como eu faço?','Como posso cadastrar minhas senhas?','Onde eu faço um novo código de acesso?','Onde uso a senha de 4 dígitos?','Onde uso a senha de 6 dígitos?','Onde uso a senha de 8 dígitos?','Onde uso o código de acesso?','Recebi mensagem/ligação/e-mail pedindo minha senha, devo informar?'];

function RandomString(){
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	for ($i = 0; $i < 10; $i++) {
		$randstring .= $characters[rand(0, strlen($characters))];
	}
	return $randstring;
}



$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "chatbot";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	foreach($perg as $value){
		$answer = RandomString();
		$sql = "INSERT INTO faq(pergunta, resposta) VALUES ('$value', '$answer')";
		$conn->exec($sql);
		echo "New record created successfully";
	}
	
	// use exec() because no results are returned
		
}catch(PDOException $e){
	echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
