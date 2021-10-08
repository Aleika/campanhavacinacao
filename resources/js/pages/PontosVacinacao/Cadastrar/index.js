import React, { useEffect, useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import api from '../../../services/api';
import Menu from '../../../components/MenuAdministrador';
import { Button, Form, FormGroup, Label, Input } from 'reactstrap';

export default function index() {
  const [nome, setNome] = useState('');
  const [bairro, setBairro] = useState('');
  const [cidade, setCidade] = useState('');
  const [logradouro, setLogradouro] = useState('');
  const token = localStorage.getItem("access_token");
  const history = useHistory();

  async function handlePontoVacinacao(e) {
    e.preventDefault();

    const data = {
      nome,
      bairro,
      cidade,
      logradouro
    };

    api.post('/pontosvacinacao', data, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        console.log(response)
        alert(response.data.message);

        history.push('/pontos/listar');
      })
      .catch(error => {
        console.log(error.response.data);
        alert(error.response.data);
      })
  }

  return (
    <div>
      <Menu />
      <main className="bg-gray-200">
        <div className="flex flex-col pt-24 container mx-auto">
          <div className="flex text-gray-700">
            <h3 className="cursor-pointer text-gray-700 mb-8 font-bold ml-2 mt-1">
              |<span className="ml-2">Pontos de Vacinação</span>
            </h3>
          </div>
          <div className="bg-white rounded shadow p-4 container mx-auto mb-10">
            <div className="flex flex-col justify-center container">
              <div className="block overflow-x-auto whitespace-no-wrap">
                <Form onSubmit={handlePontoVacinacao}>
                  <FormGroup>
                    <Label> Nome *</Label>
                    <Input required placeholder="Nome"
                      value={nome}
                      onChange={e => setNome(e.target.value)} />
                  </FormGroup>
                  <FormGroup>
                    <Label> Bairro * </Label>
                    <Input required placeholder="Bairro"
                      value={bairro}
                      onChange={e => setBairro(e.target.value)} />
                  </FormGroup>
                  <FormGroup>
                    <Label> Logradouro * </Label>
                    <Input required placeholder="Logradouro"
                      value={logradouro}
                      onChange={e => setLogradouro(e.target.value)} />
                  </FormGroup>
                  <FormGroup>
                    <Label >Cidade * </Label>
                    <Input required placeholder="Cidade"
                      value={cidade}
                      onChange={e => setCidade(e.target.value)} />
                  </FormGroup>
                  <FormGroup >
                    <Button color="primary">Cadastrar</Button> {' '}
                    <Link to={"/pontos/listar/"} className="button" >
                      <Button color="danger" left>Cancelar</Button>
                    </Link>
                  </FormGroup>
                </Form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}