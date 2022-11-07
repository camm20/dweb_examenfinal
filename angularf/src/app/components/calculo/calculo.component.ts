import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/services/auth.service';
import { faCalendarDays } from '@fortawesome/free-solid-svg-icons';
import { faStopwatch } from '@fortawesome/free-solid-svg-icons';
import { BackendService } from 'src/app/services/backend.service';
import { TokenService } from 'src/app/services/token.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-calculo',
  templateUrl: './calculo.component.html',
  styleUrls: ['./calculo.component.css']
})
export class CalculoComponent implements OnInit {

  
  public error = null;
  calcResp: any = "0";
  constructor(private Token: TokenService, private Auth: AuthService, private backend: BackendService, private router: Router) { }

  public form = {
    user_id: this.Auth.getUid(),
    vf: null,
    a: null,
    t: null,
    vi: null
  }

  ngOnInit(): void {

  }


  submitCalc() {
    return this.backend.postCalculo(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.handleError(error)
    );
  }

  handleResponse(data: any) {
    this.calcResp = data.calculo;
  }

  handleError(error: any) {
    this.error = error.error.error;
  }

  logout() {
    this.Token.remove();
    this.Auth.changeAuthStatus(false);
    this.Auth.removeUid();
    this.router.navigateByUrl('/');
  }



}