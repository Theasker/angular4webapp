import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'app-home',
    templateUrl: '../views/home.html'
})

export class HomeComponent implements OnInit {
    public titulo: string;
    constructor() {
        this.titulo = 'Webapp de productos con Angular 4';
    }

    ngOnInit() {
        console.log('Se ha cargado el componente de la Home')
    }
}
