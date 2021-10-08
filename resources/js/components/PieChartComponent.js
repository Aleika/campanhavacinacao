import React, { Component } from 'react';
import { Pie } from 'react-chartjs-2';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class PieChartComponent extends Component {
  constructor(props) {
    super(props);
    this.state = {
    }
  }

  componentDidMount() {
    axios.get(`http://localhost:8000/api/chartPorCidade`)
      .then(res => {
        const dados = res.data;
        let datas = [];
        let total = [];
        dados.forEach(element => {
          datas.push(element.cidade);
          total.push(element.total);
        });
        this.setState({
          Data: {
            labels: datas,
            datasets: [
              {
                label: 'Total de agendamentos nos últimos 7 dias',
                data: total,
                backgroundColor: [
                  'rgba(255,105,145,0.8)',
                  'rgba(155,100,210,0.6)',
                  'rgba(90,178,255,0.6)',
                  'rgba(240,134,67,0.6)',
                  'rgba(120,120,120,0.6)',
                  'rgba(250,55,197,0.6)'
                ]
              }
            ]
          }
        });
      })
  }

  render() {
    return (
      <div>
        <Pie data={this.state.Data}
          options={{ maintainAspectRatio: false }} />
      </div>
    )
  }
}

/* if (document.getElementById('app')) {
  ReactDOM.render(<PieChartComponent />, document.getElementById('app'));
} */