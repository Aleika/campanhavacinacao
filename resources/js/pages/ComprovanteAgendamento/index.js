import React, { useState, useEffect } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Menu from '../../components/MenuCidadao';
import api from '../../services/api';
import { Button } from 'reactstrap';

export default function index() {
  const [dados, setDados] = useState('');
  const [local, setLocal] = useState('');
  const history = useHistory();
  const token = localStorage.getItem("access_token");

  useEffect(() => {
    (async () => {
      const dados = await api.get("/agendamento/comprovante", { headers: { "Authorization": `Bearer ${token}` } });
      console.log(dados.data);
      setLocal(dados.data.local);
      setDados(dados.data);
    })();
  }, []);

  async function handleCancelarAgendamento(id) {

    api.delete('/agendamento/' + id, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        alert("Agendamento cancelado!");

        history.push('/agendamento');
      })
      .catch(error => {
        console.log(error);
        alert(error.response);
      })

  }

  async function handlePrint() {
    var conteudo = document.getElementById('imprimir').innerHTML,
      tela_impressao = window.open('');

    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = dd + '/' + mm + '/' + yyyy;
    conteudo = '<h1>Comprovante de Agendamento</h1> <h5>Emitido em: ' + today + ' </h5> <br/>' + conteudo + '<br/> <br/> <h5>Chave de autenticação:</h5> dkalkdAWRWER%#dswdq$21313DADXA';
    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();
  }

  return (
    <div>
      <Menu menu="Comprovante" />
      <main className="bg-gray-200">
        <div className="flex flex-col pt-24 container mx-auto">
          <div className="flex text-gray-700">
            <h3 className="text-gray-700 mb-8 font-bold ml-2 mt-1">
              <span className="ml-2">Comprovante de Agendamento</span>
            </h3>
          </div>
          <div className="bg-white rounded shadow p-4 container mx-auto mb-10" id="imprimir">
            <div className="flex flex-col justify-center container">
              <div className="block overflow-x-auto whitespace-no-wrap">
                <h3 className="text-blue-900">
                  <span className="font-bold"> <strong>Nome: </strong></span>{" "}
                  {dados.nome}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Grupo de atendimento: </strong></span>{" "}
                  {dados.grupo}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong>Data do agendamento: </strong></span>{" "}
                  <span className="uppercase">
                    {dados.data}
                  </span>
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong>Hora: </strong></span>{" "}
                  {dados.hora}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Ponto de vacinação: </strong></span>{" "}
                  {local.NO_NOME}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Sala de vacinação: </strong></span>{" "}
                  {dados.sala}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Cidade: </strong></span>{" "}
                  {local.NO_CIDADE}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Bairro: </strong></span>{" "}
                  {local.NO_BAIRRO}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong> Endereço: </strong></span>{" "}
                  {local.NO_LOGRADOURO}
                </h3>
                <h3 className="text-blue-900">
                  <span className=" font-bold"> <strong>Status do agendamento: </strong></span>{" "}
                  {dados.status}
                </h3>
              </div>
            </div>
          </div>
          <Button color="primary" onClick={handlePrint} >Imprimir comprovante</Button> {' '}
          <Button color="danger" onClick={handlePrint}
            onClick={(e) => { if (window.confirm('Tem certeza que quer cancelar o agendamento?')) handleCancelarAgendamento(dados.id) }}
          >Cancelar agendamento</Button> {' '}
        </div>
      </main>
    </div>

  )
}