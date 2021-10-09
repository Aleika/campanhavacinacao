import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import Menu from '../../components/MenuCidadao';
import api from '../../services/api';

import './styles.scss';

export default function index() {
  const [dados, setDados] = useState('');
  const [nomeMenu, setNomeMenu] = useState('');

  const token = localStorage.getItem("access_token");
  useEffect(() => {
    (async () => {
      const dados = await api.get("/auth/me", { headers: { "Authorization": `Bearer ${token}` } });
      setDados(dados.data.data);
    })();

    api.get('/agendamento/check', { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        console.log(response)
        if (response.data.possuiAgendamento) {
          setNomeMenu("Comprovante");
        } else {
          setNomeMenu("Agendamento");
        }
      })
      .catch(error => {
        alert(error.response.data.message);
      })
  }, []);

  return (
    <div>
      <Menu menu={nomeMenu} />
      <div id="page-comprovante">
        <main id='imprimir'>
          <div className="flex items-center">
            <div className="ml-2">
              <h3 className="text-blue-900">
                <span className="font-bold">Nome:</span>{" "}
                {dados.nome}
              </h3>
              <h3 className="text-blue-900">
                <span className=" font-bold">Data Nascimento:</span>{" "}
                <span className="uppercase">
                  {dados.dataNascimento}
                </span>
              </h3>
              <h3 className="text-blue-900">
                <span className=" font-bold">Email:</span>{" "}
                {dados.email}
              </h3>
              <h3 className="text-blue-900">
                <span className=" font-bold">Perfil:</span>{" "}
                {dados.perfil}
              </h3>
            </div>
          </div>
        </main>
      </div>
    </div>

  )
}