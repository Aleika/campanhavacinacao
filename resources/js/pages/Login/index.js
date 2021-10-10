import React, { useState, useEffect } from 'react';
import { Link, useHistory } from 'react-router-dom';
//import { FiLogIn } from 'react-icons/fi';
import Menu from '../../components/Menu';
import { Button } from 'reactstrap';

import api from '../../services/api';
import axios from 'axios';

import '../../pages/Register/styles.scss';

export default function Login() {
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const history = useHistory();

  useEffect(() => {
    if (localStorage.getItem("access_token") !== null) {
      const token = localStorage.getItem("access_token");
      const user = JSON.parse(localStorage.getItem("user"));
      if (user.perfil === 1) {
        history.push('/grupos/listar');
      } else {
        if (user.perfil = 2) {
          api.get('/agendamento/check', { headers: { "Authorization": `Bearer ${token}` } })
            .then(response => {
              if (response.data.possuiAgendamento) {
                history.push('/comprovante');
              } else {
                history.push('/agendamento');
              }
            })
            .catch(error => {
              alert(error.response.data.message);
            })
        }
      }
    }
  }, []);

  async function handleLogin(e) {
    e.preventDefault();

    api.post('/auth/login', { email, senha })
      .then(response => {

        const user = response.data.user;
        const token = response.data.access_token;

        localStorage.setItem("access_token", response.data.access_token);
        localStorage.setItem("user", JSON.stringify(user));

        alert(response.data.message);

        try {
          if (user.perfil == 1) {
            history.push('/grupos/listar');
          } else {
            if (user.perfil == 2) {
              api.get('/agendamento/check', { headers: { "Authorization": `Bearer ${token}` } })
                .then(response => {
                  if (response.data.possuiAgendamento) {
                    history.push('/comprovante');
                  } else {
                    history.push('/agendamento');
                  }
                })
                .catch(error => {
                  alert(error.response.data.message);
                })
            }
          }
        } catch (err) {
          alert(err.response.data.message);
        }
      })
      .catch(error => {
        alert(error.response.data.message);
      });

  }

  return (
    <div>
      <Menu />
      <div className="register-container">
        <div className="content">
          <section>
            <h1>Campanha de Vacinação contra o COVID-19</h1>
            <p>Acesse o sistema e faça o agendamento para ser vacinado contra o Covid-19 ou tenha acesso ao seu comprovante de agendamento</p>

          </section>
          <form onSubmit={handleLogin}>
            <input

              placeholder="Seu e-mail"
              value={email}
              onChange={e => setEmail(e.target.value)}
            />
            <input
              placeholder="Sua Senha"
              type="password"
              value={senha}
              onChange={e => setSenha(e.target.value)}
            />

            <Button color="primary" type="submit">Entrar</Button>
            <br />
            <Link className="back-link" to="/register">
              Não tenho cadastro
            </Link>
          </form>
        </div>
      </div>

    </div>
  );
}