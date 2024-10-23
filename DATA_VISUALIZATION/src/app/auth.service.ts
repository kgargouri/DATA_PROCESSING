import { Injectable } from '@angular/core';
import { delay, Observable, of, tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  //isLoggedIn: boolean = false;
  redirectUrl: string;

  constructor() { }

  isAuthenticated(): boolean {
    // Vérifiez si l'utilisateur est authentifié
    return !!localStorage.getItem('isLoggedIn');
  }

  login(username: string, password: string): Observable<boolean>{
    const isLoggedIn = (username == 'karim' && password == 'karim');

    return of(isLoggedIn).pipe(
      delay(1000), 
      tap(() => localStorage.setItem('isLoggedIn', 'logged'))
      //tap(isLoggedIn => this.isLoggedIn = isLoggedIn)
    );
  }

  logout(){
    localStorage.removeItem('isLoggedIn');
    //this.isLoggedIn = false;
  }
}
