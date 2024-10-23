import { Produit } from '../produit';
import { ProduitService } from './../produit.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-produit',
  templateUrl: './produit.component.html',
  styleUrl: './produit.component.css'
})
export class ProduitComponent implements OnInit {

  produitList: Produit[];

  constructor(
    private produitService: ProduitService
  ){}

  ngOnInit(): void {
    this.produitService.getProduitList().subscribe(
      produitList => this.produitList=produitList
    );
  }

}
