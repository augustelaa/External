<?php

/**
 * Arquivo feito por Augusto Henrique da Conceção
 * github: augustelaa
 * 
 * augusto_conceicao@hotmail.com
 **/

class FC{
    
    //Define a string que define arquivos abertos
    private $openedfile = array();

    //Função que é executada automaticamente assim que a classe é executada
    private function exists($file){
       
        try{
            
            //Executa um try para verificar se o arquivo não existe 
            if(!file_exists($file)){
                //Se o script chegar aqui é porque o arquivo não existe, fazendo assim lançar uma Exception
                throw new Exception("Arquivo não existe.");
            }else{
                //Se o script chegar aqui é porque o arquivo existe, retornando em "1" ou true
                return array(true,$file);
            }
            
        }catch(Exception $e){ 
            //Confirmado que o arquivo não existe a Excetion é lançada, o catch pega a Exception e ele é retornado ao invocador
            return array($e->getMessage(),$file);
        }
        
    }
    
    //Função que é executada automaticamente assim que a classe é finalizada
    public function __destruct() {
        
        //Checa se algum arquivo foi aberto pela classe
        if($this->openedfile != null){
            
            //Checa se a string é uma array, como definido
            if(is_array($this->openedfile)){
                //Faz a contagem para verificar quantos arquivos há na array
                $numeroArquivos = count($this->openedfile);
                //Verifica se o numero de arquivos na array é maior que -1
                if($numeroArquivos >= 0){
                    $numeroArquivos;
                    //Faz um loop para fechar os arquivos automaticamente
                    while($numeroArquivos >= 0){
                        //Fecha o arquivo conforme é dado seu número (Com @ para evitar mensagens de erro, alguns arquivos podem não existir travando a função.)
                        @fclose($this->openedfile[$numeroArquivos]);
                        //Define o numero de arquivos reduzindo um por um, pois cada arquivo é fechado desta forma
                        $numeroArquivos = $numeroArquivos -1;
                    }
                }
            }
            
            //Afirma que foi fechado fazendo com que nada esteja aberto na string
            $this->openfile = null;
        }
        
    }
    
    //Função para editar arquivos
    public function writeIN($file, $param){
        
        //Verifica se o arquivo existe e é editavel por segurança
        $returned = self::canWrite($file);
        //Se o resultante for "1" ou true continua a função
        if($returned == 1){
            
            //Verifica se ja há arquivos na string-array
            if($this->openedfile != null){
                //Verifica quantos são e continua a verificação
                $numeroArquivos = count($this->openedfile);
                //Verifica se o numero de arquivos na array é maior que -1
                if($numeroArquivos >= 0){
                    //Seta o novo numero para a string
                    $newnumber = $numeroArquivos +1;
                                        
                    try{
                    //Abre o arquivo com a+ (ler e editar)
                    $handle = fopen($file, "a+");
                    //Seta a string-array
                    $this->openedfile[$newnumber] = $handle;
                    if($handle){
                    //Escreve o parametro dado no arquivo
                    fwrite($handle, $param);
                    return true;
                    }else{
                        throw new Exception("Arquivo não pode ser aberto.");
                    }
                    }catch(Exception $e){
                        return $e->getMessage();
                    }
                }
            }else{
                    //Não há arquivos, continua a função
                                    
                    try{
                    //Abre o arquivo com a+ (ler e editar)
                    $handle = fopen($file, "a+");
                    $this->openedfile[1] = $handle;
                    if($handle){
                    //Escreve o parametro dado no arquivo
                    fwrite($handle, $param);
                    return true;
                    }else{
                        throw new Exception("Arquivo não pode ser aberto.");
                    }
                    }catch(Exception $e){
                        return $e->getMessage();
                    }
            }
            
        }else{
            echo $returned;
        }
        
    }
    
    //Função que verificada se o arquivo é editavel
    public function canWrite($file){
        
        //Verifica se o arquivo (função exists) existe por segurança
        $returned = self::exists($file);
        //Se o resultante for "1" ou true continua a função
        if($returned[0] == 1){          
             
        try{
            
            //Executa um try para verificar se o arquivo é editavel
            if(!is_writable($file)){
                //Se o script chegar aqui é porque o arquivo não é editavel, fazendo assim lançar uma Exception
                throw new Exception("Arquivo não editavel.");
            }else{
                //Se o script chegar aqui é porque o arquivo é editavel, retornando em "1" ou true
                return true;
            }
            
        }catch(Exception $e){ 
            //Confirmado que o arquivo não é editavel a Excetion é lançada, o catch pega a Exception e ele é retornado ao invocador
            return $e->getMessage(); }        
            
        }else{
            //Se o resultante for uma Exception ele congela a função
            return $returned[0];
        }
    }
    
    
}
?>