export class Produit{
    id: number;
    nom: string;
    categorie: string;
    sous_categorie: string;
    cout_unitaire: string;
    prix_unitaire: string;
    constructor(){
        this.id=0;
        this.nom='';
        this.categorie='';
        this.sous_categorie = '';
        this.cout_unitaire = "";
        this.prix_unitaire='';
    }
}