import { Component, OnInit } from '@angular/core';
import { Produit } from '../produit';
import { ProduitService } from '../produit.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-produit-edit',
  templateUrl: './produit-edit.component.html',
  styleUrl: './produit-edit.component.css'
})
export class ProduitEditComponent implements OnInit {
  
  produit: Produit|undefined;

  constructor(
    private produitService: ProduitService,
    private route: ActivatedRoute
  ){}
  
  ngOnInit(): void {
    const produitId: string|null = this.route.snapshot.paramMap.get('id');
    if(produitId){
      this.produitService.getProduitById(+produitId).subscribe(
        produit => this.produit=produit
      );
    }else{
      this.produit = undefined;
    }
  }
}
