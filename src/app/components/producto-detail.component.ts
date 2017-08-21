import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { ProductoService } from '../services/producto.service';
import { Producto } from '../models/producto';
import { GLOBAL } from '../services/global';

@Component({
    selector: 'app-producto-detail',
    templateUrl: '../views/producto-detail.html',
    providers: [ProductoService]
})

export class ProductoDetailComponent implements OnInit {
    public producto: Producto;
    public urlBase: string;

    constructor(
        private _productoService: ProductoService,
        private _route: ActivatedRoute,
        private _router: Router
    ) {
        this.urlBase = GLOBAL.urlBase;
    }

    ngOnInit() {
        console.log('producto-detail.component.ts cargado');
        this.getProducto();
    }

    getProducto() {
        this._route.params.forEach((params: Params) => {
            const id = params['id'];
            this._productoService.getProducto(id).subscribe(
                response => {
                    console.log('response: ', response);

                    if (response.code === 200) {
                        this.producto = response.data;
                        console.log('this.producto: ', this.producto);
                    }else {
                        this._router.navigate(['/productos']);
                    }
                },
                error => {
                    console.log(<any>error);
                }
            );
        })
    }

}
