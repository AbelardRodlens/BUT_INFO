import java.util.ArrayList;
import ardoise.*;

public class Triangle extends Forme {
    private ArrayList<Segment> segments;
    private static final String typeforme = "T";
    
    public Triangle(String nom, Segment S1, Segment S2, Segment S3) throws PointsTropGrandsException {
        super(nom);
        this.segments = new ArrayList<Segment>();

        try {
            checkForNullPoints(S1, S2, S3);
             } catch (NullPointerException e) {
            segments.add(new Segment(new PointPlan(-1, -1), new PointPlan(-2, -2)));
            System.out.println("Error: One or more segments have null points. " + e.getMessage());
        }
        try {
            checkForLargePoints(S1, S2, S3);
            segments.add(S1);
            segments.add(S2);
            segments.add(S3);}
        catch(PointsTropGrandsException e) {
        	System.out.println(e.getMessage());
        	segments.add(new Segment(new PointPlan(-1, -1), new PointPlan(-2, -2)));
        }
       
    }

    private void checkForNullPoints(Segment... segments) throws NullPointerException {
        for (Segment segment : segments) {
            segment.getPointDepart();
            segment.getPointArrivee();
        }
    }

    private void checkForLargePoints(Segment... segments) throws PointsTropGrandsException {
        for (Segment segment : segments) {
            if (segment.getPointDepart().getAbscisse() > 2000 || segment.getPointDepart().getOrdonnee() > 2000 ||
                    segment.getPointArrivee().getAbscisse() > 2000 || segment.getPointArrivee().getOrdonnee() > 2000) {
                throw new PointsTropGrandsException("Error: Points of a segment exceed the limit of 2000.");
            }
        }
    }

    @Override
    public void deplacer(int arg0, int arg1) {
        segments.get(0).deplacer(arg0, arg1);
        segments.get(1).deplacer(arg0, arg1);
    }

    @Override
    public ArrayList<Segment> dessiner() {
        return segments;
    }

    @Override
    public String typeForme() {
        return typeforme;
    }
}

