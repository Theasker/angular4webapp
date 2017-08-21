import { Component } from '@angular/core';
import { GLOBAL } from './services/global';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  public title: string;
  public header_color: string;

  constructor() {
    this.title = 'Productos Angular 4';
    this.header_color = GLOBAL.header_color;
  }
}
