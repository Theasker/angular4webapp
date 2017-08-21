import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { ProductoService } from '../services/producto.service';
import { Producto } from '../models/producto';
import { GLOBAL } from '../services/global';
declare var jQuery: any;
declare var $: any;

@Component({
    selector: 'app-productos-list',
    templateUrl: '../views/productos-list.html',
    providers: [ProductoService]
})

export class ProductosListComponent implements OnInit {
    public titulo: string;
    public productos: Producto[];
    public urlBase: string;
    public confirmado: number; // Se le asignará el id del producto

    constructor(
        private _route: ActivatedRoute,
        private _router: Router,
        private _productoService: ProductoService
    ) {
        this.titulo = 'Listado de productos';
        this.urlBase = GLOBAL.urlBase;
        this.confirmado = null;
    }

    ngOnInit() {
        console.log('Cargado el componente producto-lists.component.ts');
        this.getProductos();
        $('body').css('background', '#eee');
    }

    borrarConfirm(id: number) {
        this.confirmado = id;
    }

    cancelarConfirm() {
        this.confirmado = null;
    }

    onDeleteProducto(id: number) {
        this._productoService.deleteProducto(id).subscribe(
            response => {
                if (response.code === 200) {
                    this.getProductos();
                }else {
                    console.log('Error al borrar producto');
                }
            },
            error => {
                console.log(<any>error);
            }
        )
    }

    getProductos() {
        this._productoService.getProductos().subscribe(
            result => {
                if (result.code !== 200) {
                    console.log('result: ', result);
                }else {
                    this.productos = result.data;
                    console.log('this.productos: ', this.productos);
                }
            },
            error => {
                console.log(<any>error);
            }
        );
    }
}
