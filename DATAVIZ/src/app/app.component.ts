import { Component, OnInit } from '@angular/core';
import { AuthService } from './auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent implements OnInit {
  isLogged: boolean = false;
  constructor(private authService: AuthService, private router: Router){}
  ngOnInit(): void {
    if(!!localStorage.getItem('isLoggedIn')){
      this.isLogged = true;
    }
  }

  logout(){
    console.log("déconnecté");
    this.authService.logout();
    this.router.navigate(['/login']);
  }
  
}
