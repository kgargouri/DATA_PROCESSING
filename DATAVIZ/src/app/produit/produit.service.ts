import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { catchError, Observable, of, tap } from 'rxjs';
import { Produit } from './produit';

@Injectable({
  providedIn: 'root'
})
export class ProduitService {

  constructor(private http: HttpClient) { }

  getProduitList(): Observable<Produit[]> {
    return this.http.get<Produit[]>('http://localhost:8000/api/produits/').pipe(
      tap((response) => console.table(response)),
      catchError((error) => {
        console.log(error);
        return of([]);
      })
    )
  }

  getProduitById(produitId: number): Observable<Produit|undefined> {
    return this.http.get<Produit>(`http://localhost:8000/api/produits/${produitId}`).pipe(
      tap((response) => console.table(response)),
      catchError((error) => {
        console.log(error);
        return of(undefined);
      })
    );
  }

  updateProduit(produit: Produit): Observable<null|any>{
    const httpOptions ={
      headers: new HttpHeaders({'content-type': 'application/json'})
    };

    return this.http.put(`http://localhost:8000/api/produits/${produit.id}`, produit, httpOptions).pipe(
      tap((response) => console.table(response)),
      catchError((error) => {
        console.log(error);
        return of(null);
      })
    );
  }

  addProduit(produit: Produit): Observable<Produit|any>{
    const httpOptions ={
      headers: new HttpHeaders({'content-type': 'application/json'})
    };
    
    return this.http.post<Produit>(`http://localhost:8000/api/produits`, produit, httpOptions).pipe(
      tap((response) => console.table(response)),
      catchError((error) => {
        console.log(error);
        return of(null);
      })
    );
  }

  delteProduitById(produitId: number): Observable<null|any>{
    return this.http.delete(`http://localhost:8000/api/produits/${produitId}`).pipe(
      tap((response) => console.table(response)),
      catchError((error) => {
        console.log(error);
        return of(null);
      })
    );;
  }

}
