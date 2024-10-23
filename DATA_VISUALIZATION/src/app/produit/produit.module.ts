import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProduitService } from './produit.service';
import { ProduitComponent } from './produit/produit.component';
import { RouterModule, Routes } from '@angular/router';
import { ProduitDetailComponent } from './produit-detail/produit-detail.component';
import { ProduitAddComponent } from './produit-add/produit-add.component';
import { FormsModule } from '@angular/forms';
import { ProduitFormComponent } from './produit-form/produit-form.component';
import { ProduitEditComponent } from './produit-edit/produit-edit.component';
import { authGuard } from '../auth.guard';


const produitRoutes: Routes = [
  {
    path : 'produits',
    component: ProduitComponent
  },
  {
    path: 'produits/add',
    component: ProduitAddComponent,
    canActivate: [authGuard]
  },
  {
    path: 'produits/edit/:id',
    component: ProduitEditComponent,
    canActivate: [authGuard]
  },
  {
    path: 'produits/:id',
    component: ProduitDetailComponent
  }
];

@NgModule({
  declarations: [
    ProduitComponent,
    ProduitDetailComponent,
    ProduitAddComponent,
    ProduitFormComponent,
    ProduitEditComponent
  ],
  imports: [
    CommonModule,
    FormsModule,
    RouterModule.forChild(produitRoutes)
  ],
  providers: [ProduitService]
})
export class ProduitModule { }
