import React, { useEffect, useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import api from '../../../services/api';
import Menu from '../../../components/MenuAdministrador';

import './styles.scss';

export default function index() {
  const [pontosVacinacao, setPontosVacinacao] = useState([]);

  const token = localStorage.getItem("access_token");
  const history = useHistory();

  useEffect(() => {
    if (localStorage.getItem("access_token") !== null) {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user.perfil !== 1) {
        alert("Sem permissão de acesso");
        history.push('/');
      }
    }
  }, []);

  async function handleSearch() {
    let pesquisa = document
      .getElementById("pesquisarPonto")
      .value.toUpperCase();

    if (pesquisa.length == 0) {
      const pontos = await api.get("/pontosvacinacao", { headers: { "Authorization": `Bearer ${token}` } });
      setPontosVacinacao(pontos.data.data);
    } else {
      if (pesquisa.length > 3) {
        api.get(`/pontosvacinacao?nome=${pesquisa}`, { headers: { "Authorization": `Bearer ${token}` } })
          .then(response => {
            setPontosVacinacao(response.data.data);
          })
          .catch(error => {
            alert(error.response.data.message);
          });
      }
    }
  }

  async function handleRemover(id) {

    try {
      const resposta = await api.delete('/pontosvacinacao/' + id, { headers: { "Authorization": `Bearer ${token}` } });
      alert("Removido com sucesso");

      window.location.reload();
    } catch (err) {
      alert(err.response.data.message);
    }
  }

  useEffect(() => {
    (async () => {
      const pontos = await api.get("/pontosvacinacao", { headers: { "Authorization": `Bearer ${token}` } });
      setPontosVacinacao(pontos.data.data);
    })();
  }, []);

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
          <Link
            to="/pontos/cadastrar"
            className="flex items-center text-decoration-none rounded text-blue-900 font-bold border-2 border-blue-900 mb-5 px-6 py-1 self-end"
          >
            <span className="ml-2">Cadastrar novo ponto de vacinação</span>
          </Link>
          {!pontosVacinacao.length && (
            <p>Não pontos de vacinação cadastrados!</p>
          )}
          <div className="bg-white rounded shadow p-4 container mx-auto mb-10">
            <div className="container">
              <div className="row">
                <div className="col-12 col-md-8">
                  <div></div>
                </div>
                <div className="col-12 col-md-4">
                  <div>
                    <label className="m-2">
                      Pesquisar
                    </label>
                    <div className="position-relative">
                      <input
                        type="text"
                        name="pesquisar"
                        id="pesquisarPonto"
                        className=" rounded bg-gray-100 border border-gray-300 form-control"
                        onChange={handleSearch}
                        style={{
                          textTransform:
                            "uppercase"
                        }}
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="flex flex-col justify-center container">
              <div className="block overflow-x-auto whitespace-no-wrap">
                <table className="text-left">
                  <thead
                    className=""
                    style={{
                      fontFamily: "Open Sans, sans-serif"
                    }}
                  >
                    <tr>
                      <th className="text-blue-900 sm:px-1 md:px-4">
                        Nome
                      </th>
                      <th className="text-blue-900 sm:px-1 md:px-4 text-center">
                        Bairro
                      </th>
                      <th className="text-blue-900 sm:px-1 md:px-4 text-center">
                        Cidade
                      </th>
                      <th className="text-blue-900"></th>
                    </tr>
                  </thead>
                  <tbody>
                    {pontosVacinacao.map(pontoVacinacao => (
                      <tr className="odd:bg-gray-300" key={pontoVacinacao.id}>
                        <td className="uppercase py-3 sm:px-1 md:px-3 pr-3">
                          {pontoVacinacao.nome}
                        </td>
                        <td className="sm:px-1 md:px-3 text-center px-4">
                          {pontoVacinacao.bairro}
                        </td>
                        <td className="sm:px-1 md:px-3 text-center px-4">
                          {pontoVacinacao.cidade}
                        </td>
                        <td className="text-center text-center">
                          <Link
                            to={"/pontos/editar/" + pontoVacinacao.id}
                            className="bg-blue-900 hover:bg-blue-800 px-3 md:px-4 py-2 rounded text-decoration-none"
                          >
                            Editar
                          </Link>
                        </td>
                        <td className="text-center">
                          <button onClick={(e) => { if (window.confirm('Tem certeza que quer remover este ponto de vacinação?')) handleRemover(pontoVacinacao.id) }}
                            className="px-2 md:px-4 py-2 rounded text-decoration-none"
                          > Remover </button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
              <hr className="border border-blue-900 mb-2" />
              <div
                className="flex justify-between items-center"
                style={{
                  fontFamily: "Open Sans, sans-serif"
                }}
              >
                <span className="text-gray-800">
                  Página: 1
                </span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}