import { Component, OnInit } from '@angular/core';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit {

  message: string = 'Vous êtes déconnecté.';
  alertClass: string = 'alert-warning';
  username: string;
  password: string;
  auth: AuthService;
  isLoggedIn: boolean = false;

  constructor(
    private authService: AuthService,
    private router: Router
  ){}
  
  ngOnInit(): void {
    this.auth = this.authService;
  }

  setMessage(){
    if(this.auth.isAuthenticated()){
      this.message = 'Vous êtes connecté.';
      this.alertClass = 'alert-success';
    }else{
      this.message = 'Veuillez vérifier votre pseudo ou mot de passe !';
      this.alertClass = 'alert-danger';
    }
  }

  login(){
    this.message = 'Tentative de connexion en cours...';
    this.alertClass = 'alert-info';
    this.auth.login(this.username, this.password).subscribe(
      (isLoggedIn: boolean) => {
        this.setMessage();
        if(isLoggedIn){
          this.isLoggedIn = true;
          this.router.navigate(['/produits/add']);
        }else{
          this.password = '';
          this.isLoggedIn = false;
          this.router.navigate(['/login']);
        }
      }
    );
  }

  /*logout(){
    this.auth.logout;
    this.message = 'Vous êtes connecté.';
    this.alertClass = 'alert-warning';
  }*/
}
