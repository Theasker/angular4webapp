import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'app-error',
    templateUrl: '../views/error.html'
})

export class ErrorComponent {
    public titulo: string;

    constructor() {
        this.titulo = 'Error 404: Página no encontrada';
    }

    ngOninit() {
        console.log('Componente error.component.ts cargado');
    }
}