import { Component, OnInit } from '@angular/core';
import { Produit } from '../produit';

@Component({
  selector: 'app-produit-add',
  templateUrl: './produit-add.component.html',
  styleUrl: './produit-add.component.css'
})
export class ProduitAddComponent implements OnInit {

  produit: Produit;

  ngOnInit(): void {
    this.produit = new Produit();
  }
}
