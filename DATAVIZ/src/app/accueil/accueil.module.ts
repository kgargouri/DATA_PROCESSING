import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AccueilComponent } from './accueil/accueil.component';
import { RouterModule, Routes } from '@angular/router';

const accueilRoutes: Routes = [
  {
    path : '',
    component: AccueilComponent
  }
];

@NgModule({
  declarations: [
    AccueilComponent
  ],
  imports: [
    CommonModule,
    RouterModule.forChild(accueilRoutes)
  ]
})
export class AccueilModule { }
