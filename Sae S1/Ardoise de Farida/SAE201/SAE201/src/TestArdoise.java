import java.util.ArrayList;

import ardoise.*;
public class TestArdoise {

	public static void main(String[] args) throws Exception {
	
			Ardoise art= new Ardoise();
			
		
			Segment s3= new Segment(new PointPlan(118,13),new PointPlan(123,20));
			Segment s4= new Segment(new PointPlan(123,20),new PointPlan(128,13));
	
			Chapeau Oiseau1=new Chapeau("Oiseau 1",s3,s4);
			
			Segment s1= new Segment(new PointPlan(133,30),new PointPlan(136,32));
			Segment s2= new Segment(new PointPlan(136,32),new PointPlan(138,30));
	
			Chapeau Oiseau2=new Chapeau("Oiseau 2",s1,s2);
			
			Segment s6= new Segment(new PointPlan(142,14),new PointPlan(144,17));
			Segment s5= new Segment(new PointPlan(144,17),new PointPlan(146,14));
			
			Chapeau Oiseau3=new Chapeau("Oiseau 3",s6,s5);
			
			Segment s7= new Segment(new PointPlan(9,100),new PointPlan(20,100));
			Segment s8= new Segment(new PointPlan(20,100),new PointPlan(20,198));
			Segment s9= new Segment(new PointPlan(20,198),new PointPlan(9,198));
			Segment s10= new Segment(new PointPlan(9,198),new PointPlan(9,100));
			
			Quadrilatère Tour=new Quadrilatère("Tour",s7,s8,s9,s10);
			
			/*maison debut*/
			Segment s11= new Segment(new PointPlan(80,140),new PointPlan(180,140));
			Segment s12= new Segment(new PointPlan(180,140),new PointPlan(180,198));
			Segment s13= new Segment(new PointPlan(180,198),new PointPlan(80,198));
			Segment s14= new Segment(new PointPlan(80,198),new PointPlan(80,140));
			
			Quadrilatère Corps_maison=new Quadrilatère("Corps maison",s11,s12,s13,s14);
			
			Segment s15= new Segment(new PointPlan(120,170),new PointPlan(140,170));
			Segment s16= new Segment(new PointPlan(140,170),new PointPlan(140,198));
			Segment s17= new Segment(new PointPlan(140,198),new PointPlan(120,198));
			Segment s18= new Segment(new PointPlan(120,198),new PointPlan(120,170));
			
			Quadrilatère porte_maison=new Quadrilatère("Porte maison",s15,s16,s17,s18);
			
			Segment s19= new Segment(new PointPlan(80,140),new PointPlan(130,100));
			Segment s20= new Segment(new PointPlan(130,100),new PointPlan(180,140));
	
			Chapeau Toit_maison=new Chapeau("Toit maison",s19,s20);
			
			ArrayList<Forme> F=new ArrayList<Forme>();
			F.add(porte_maison);
			F.add(Toit_maison);
			F.add(Corps_maison);
			GF maison=new GF("maison",F);
			/*maison fin*/

			/*étoile début*/
			Segment s21= new Segment(new PointPlan(170,52),new PointPlan(173,45));
			Segment s22= new Segment(new PointPlan(173,45),new PointPlan(177,52));
	
			Chapeau branche1=new Chapeau("branche 1",s21,s22);
			
			Segment s23= new Segment(new PointPlan(177,52),new PointPlan(184,57));
			Segment s24= new Segment(new PointPlan(184,57),new PointPlan(177,60));
	
			Chapeau branche2=new Chapeau("branche 2",s23,s24);
			
			Segment s25= new Segment(new PointPlan(177,60),new PointPlan(174,66));
			Segment s26= new Segment(new PointPlan(174,66),new PointPlan(170,60));
			
			Chapeau branche3=new Chapeau("branche 3",s25,s26);
			
			Segment s27= new Segment(new PointPlan(170,60),new PointPlan(164,57));
			Segment s28= new Segment(new PointPlan(164,57),new PointPlan(170,52));
			
			Chapeau branche4=new Chapeau("branche 4",s27,s28);
			
			ArrayList<Forme> F2=new ArrayList<Forme>();
			F2.add(branche1);
			F2.add(branche2);
			F2.add(branche3);
			F2.add(branche4);
			GF etoile=new GF("étoile",F2);
			/*étoile fin*/
	
			/*montagnes début*/
			Segment s29= new Segment(new PointPlan(3,14),new PointPlan(43,3));
			Segment s30= new Segment(new PointPlan(43,3),new PointPlan(112,14));
			Segment s31= new Segment(new PointPlan(112,14),new PointPlan(3,14));
			
			Triangle montagne1=new Triangle("Montage 1",s29,s30,s31);
			
			Segment s32= new Segment(new PointPlan(152,7),new PointPlan(166,3));
			Segment s33= new Segment(new PointPlan(166,3),new PointPlan(172,7));
			Segment s34= new Segment(new PointPlan(172,7),new PointPlan(152,7));
			
			Triangle montagne2=new Triangle("Montagne 2",s32,s33,s34);
			/*montagnes fin*/
			

			
			/*ajouts à l'ardoise
			art.ajouterForme(Oiseau1);
			art.ajouterForme(Oiseau2);
			art.ajouterForme(Oiseau3);
			art.ajouterForme(Tour);
			art.ajouterForme(maison);
			art.ajouterForme(etoile);
			art.ajouterForme(montagne1);
			art.ajouterForme(montagne2);
			*/
	
			Segment s292= new Segment(new PointPlan(3,14),new PointPlan(43,3));
			Segment s302= new Segment(new PointPlan(43,3),new PointPlan(112,14));
			Segment s242= new Segment(new PointPlan(0,0),new PointPlan(0,2001));

			Triangle test=new Triangle("Montage 1",s292,s302,s242);
			
			art.ajouterForme(test);
			/*affichage*/
			try {
				art.dessinerGraphique();
				Thread.sleep(3000);
				art.deplacer(Oiseau1.typeForme(), 10, 20);
			} catch (InterruptedException e) {
				e.printStackTrace();
			}
			
		}
		
		
	}


