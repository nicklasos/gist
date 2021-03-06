import _ from 'lodash';

const colors = {
    red: {
        borderColor: 'rgb(233, 30, 99)',
        backgroundColor: 'rgb(233, 30, 99, 0.8)',
    },
    green: {
        borderColor: 'rgb(76, 175, 80)',
        backgroundColor: 'rgb(76, 175, 80, 0.8)',
    },
    blue: {
        borderColor: 'rgb(52, 144, 220)',
        backgroundColor: 'rgb(52, 144, 220, 0.8)',
    },
    purple: {
        borderColor: 'rgb(156, 39, 176)',
        backgroundColor: 'rgb(156, 39, 176, 0.8)',
    },
    orange: {
        borderColor: 'rgb(255, 159, 50)',
        backgroundColor: 'rgb(255, 159, 50, 0.8)',
    },
    yellow: {
        borderColor: 'rgb(255, 206, 73)',
        backgroundColor: 'rgb(255, 206, 73, 0.8)',
    },
    lightyellow: {
        borderColor: 'rgb(255, 231, 166)',
        backgroundColor: 'rgb(255, 231, 166, 0.8)',
    },
    grey: {
        borderColor: 'rgb(201, 203, 207)',
        backgroundColor: 'rgb(201, 203, 207, 0.8)',
    }
};

export class ChartJS {
    constructor() {
        this.ids = {};
    }

    draw(id, params) {

        let {
            type,
            labels,
            options,
            datasets,
        } = params;

        type = type || 'line';
        options = options || {};

        const defaultOptions = {
            tooltips: {
                mode: 'index',
                intersect: false,
            },
        };

        const data = datasets.map(dataset => {
            let item = {
                borderWidth: dataset.hasOwnProperty('borderWidth') ? dataset.borderWidth : 1,
                pointRadius: dataset.hasOwnProperty('pointRadius') ? dataset.pointRadius : 2,
                fill: dataset.fill || false,
            };

            if (dataset.hasOwnProperty('color')) {
                item.borderColor = colors[dataset.color].borderColor;
                item.backgroundColor = colors[dataset.color].backgroundColor;
            }

            return _.merge(dataset, item);
        });

        if (this.ids.hasOwnProperty(id)) {
            this.ids[id].data.labels = labels;
            this.ids[id].data.datasets = data;
            this.ids[id].update();
        } else {
            this.ids[id] = new Chart(document.getElementById(id).getContext('2d'), {
                type,
                options: _.merge(defaultOptions, options),
                data: {
                    labels,
                    datasets: data
                },
            });
        }
    }

    destroyAll() {
        Object.keys(this.ids).forEach(id => {
            this.ids[id].destroy();
        });

        this.ids = {};
    }
}
