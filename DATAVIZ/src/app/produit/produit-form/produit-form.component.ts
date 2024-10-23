import { Component, Input, OnInit } from '@angular/core';
import { Produit } from '../produit';
import { ProduitService } from '../produit.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-produit-form',
  templateUrl: './produit-form.component.html',
  styleUrl: './produit-form.component.css'
})
export class ProduitFormComponent implements OnInit {

  @Input() produit: Produit;
  isAddForm: boolean;

  constructor(
    private produitService: ProduitService,
    private router: Router
  ){}

  ngOnInit(): void {
    //console.table(this.produit);
    this.isAddForm = this.router.url.includes('add');
  }
  onSubmit(){
    if(this.isAddForm){
      this.produitService.addProduit(this.produit).subscribe(
        (produitId: number) => this.router.navigate(['/produits', produitId])
      );
    }else{
      this.produitService.updateProduit(this.produit).subscribe(
        () => this.router.navigate(['produits', this.produit.id])
      );
    }
  }
}
