import React from 'react';
import { Link } from 'react-router-dom';
import BarChartComponent from '../../components/BarChartComponent';
import PieChartComponent from '../../components/PieChartComponent';

import './styles.scss';

export default function index() {

  return (
    <div id="page-auth">
      <aside>
        <strong>Campanha de vacinação contra o COVID-19.</strong>
        <p>Venha fazer parte e vamos derrotar esse vírus juntos!</p>

        <h5>Veja o total de agendamentos por dia na última semana:</h5>
        <BarChartComponent />
        <br />
        <h5>Veja o total de agendamentos por cidade com maior número de agendamentos:</h5>
        <PieChartComponent />
      </aside>
      <main>
        <div className="main-content">
          <Link className="back-link" to="/login" className="create">
            Faça o seu login aqui
          </Link>
          <div className="separator">
            <Link className="back-link" to="/register">
              ou realize o seu cadastro
            </Link>
          </div>
        </div>
      </main>
    </div>
  )
}