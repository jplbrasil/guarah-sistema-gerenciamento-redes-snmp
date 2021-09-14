<?php

print "<HTML>\n";

print "<HEAD><TITLE>Guará - Sistema de Gerenciamento de Redes</TITLE></HEAD>\n";

print "<BODY BGCOLOR=\"#BBCCDD\" ALINK=\"BLUE\" VLINK=\"BLUE\" LINK=\"BLUE\">\n";
print "<TABLE BORDER=1 ALIGN=\"CENTER\">\n";
print "<TR>\n";
print "<TD BGCOLOR=\"#EEEEEE\" WIDTH=\"400\">\n";
print "<CENTER>\n";
print "<IMG SRC=\"logo.gif\" BORDER=0>\n";
print "<BR>\n";
print "<FONT SIZE=4 COLOR=\"#4B2592\"><U>GUARÁ</U></FONT>\n";
print "</CENTER>\n";
print "<BR>\n";
print "<CENTER>\n";
print "<FONT SIZE=2 COLOR=\"#4B2592\">Sistema de Gerenciamento de Redes</FONT>\n";
print "</CENTER>\n";
print "<BR>\n";
print "</TD>\n";
print "</TR>\n";
print "<TR>\n";
print "<TD BGCOLOR=\"#DDDDDD\">\n";
print "<BR><BR>\n";
print "<TABLE BORDER=0 ALIGN=CENTER>\n";
print "<TR>\n";
print "<TD>\n";
print "<FORM ACTION=\"tela_selecao_rede.php\" METHOD=POST>\n";
print "<B><FONT COLOR=\"BLACK\">Usuário:</FONT></B>\n";
print "</TD>\n";
print "<TD>\n";
print "<INPUT TYPE=\"TEXT\" NAME=\"login\">\n";
print "</TD>\n";
print "</TR>\n";
print "<TR>\n";
print "<TD>\n";
print "<B><FONT COLOR=\"BLACK\">Senha:</FONT></B>\n";
print "</TD>\n";
print "<TD>\n";
print "<INPUT TYPE=\"PASSWORD\" NAME=\"senha\">\n";
print "</TD>\n";
print "</TR>\n";
print "<TR>\n";
print "<TD>\n";
print "<BR>\n";
print "<INPUT TYPE=\"SUBMIT\" NAME=\"SUBMIT\" VALUE=\"Entrar\">\n";
print "</TD>\n";
print "</TR>\n";
print "</TABLE>\n";
print "<BR>\n";
print "</TD>\n";
print "</TR>\n";
print "</TABLE>\n";

if(isset($login_incorreto)) {
	print "<BR>\n";
	print "<CENTER>\n";
	print "Erro ao entrar no sistema. Usuário ou senha inválidos.\n";
	print "<CENTER>\n";
}

print "</BODY>\n";
print "</HTML>\n";

?>
