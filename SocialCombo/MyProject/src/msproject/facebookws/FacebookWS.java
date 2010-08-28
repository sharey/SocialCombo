/**
 * Web Service - Upload photo to different social network sites
 * @author Megha Shettar
 *
 */
package msproject.facebookws;

import java.io.InputStream;
import javax.ws.rs.Consumes;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

import com.restfb.DefaultFacebookClient;
import com.restfb.FacebookClient;
import com.restfb.FacebookException;
import com.restfb.Parameter;
import com.restfb.types.FacebookType;
import com.restfb.types.User;
import com.sun.jersey.multipart.FormDataBodyPart;
import com.sun.jersey.multipart.FormDataMultiPart;

import twitter4j.TwitterException;
import twitter4j.conf.Configuration;
import twitter4j.conf.ConfigurationBuilder;
import twitter4j.http.AccessToken;
import twitter4j.http.OAuthAuthorization;
import twitter4j.util.ImageUpload;

@Path("/upload")
public class FacebookWS {
	
	/**
	 * Method to accept the form data from the client
	 * @param formData
	 * @return String
	 */
	@POST
	@Consumes(MediaType.MULTIPART_FORM_DATA)
	@Produces(MediaType.TEXT_PLAIN)
    public String upload(FormDataMultiPart formData) {
		
	     String access_token_fb = "";
	     String access_token_tw = "";
	     String consumer_key = "";
	     String consumer_secret = "";
	     String api_key = "";
	     String access_secret = "";
	     Integer service_map = 0;
	     InputStream photo_stream = null;
	     InputStream duplicate_photo_stream = null;
	     String url = "";
	     String res = "500|500|Error";
     
    	 //Parsing the MultiPartForm Data
	     FormDataBodyPart access_token_fb_body = formData.getField("access_token_fb");
	     access_token_fb = access_token_fb_body.getValue();
	     
	     FormDataBodyPart access_token_tw_body = formData.getField("access_token_tw");
	     access_token_tw = access_token_tw_body.getValue();
	     
	     FormDataBodyPart photo_stream_body = formData.getField("photo_stream");
	     photo_stream = photo_stream_body.getValueAs(InputStream.class);
	     duplicate_photo_stream = photo_stream_body.getValueAs(InputStream.class);
	     
	     FormDataBodyPart access_secret_body = formData.getField("access_secret");
	     access_secret = access_secret_body.getValue();
	     
	     FormDataBodyPart consumer_token_body = formData.getField("consumer_key");
	     consumer_key = consumer_token_body.getValue();
	     
	     FormDataBodyPart consumer_secret_body = formData.getField("consumer_secret");
	     consumer_secret = consumer_secret_body.getValue();
	     
	     FormDataBodyPart api_key_body = formData.getField("api_key");
	     api_key = api_key_body.getValue();
	   
	     FormDataBodyPart service_map_body = formData.getField("service_map");
	     service_map = Integer.parseInt(service_map_body.getValue()) ;
	   
	     //System.out.println("acces token facebook= " + access_token_fb);
	     //System.out.println("acces token Twitter = " + access_token_tw);
	     //System.out.println("photo stream = " + photo_stream);
	     //System.out.println("access secret = " + access_secret);
	     //System.out.println("consumer token = " + consumer_key);
	     //System.out.println("consumer secret = " + consumer_secret);
	     //System.out.println("api key = " + api_key);
	     //System.out.println("service map = " + service_map);
	        
	     switch (service_map) {
	     	case 1: res = facebookUploadPic(access_token_fb, photo_stream); 
	     			System.out.println("Uploaded to Facebook");
	     			res = res+"|000|Uploaded to Facebook";
	     			break;
	     	case 2: url = twitterUploadPic(access_token_tw, access_secret,photo_stream,consumer_key,
    		 								consumer_secret,api_key);
	     			System.out.println("Uploaded to Twitter");
	     			res = "000|"+url;
	     			break;
	     	case 3: res = facebookUploadPic(access_token_fb, photo_stream); 
	     			url = twitterUploadPic(access_token_tw, access_secret,
	     									duplicate_photo_stream,consumer_key,
	     									consumer_secret,api_key);
		 			System.out.println("Uploaded to Facebook & Twitter");
		 			res = res+"|"+url;
		 			break;
 		    default: break;
	     }	         	
	return res;
    }
	
	/**
	 * Method to uploads the picture to facebook
	 * @param access_token
	 * @param photo_stream
	 * @return String
	 */
	public String facebookUploadPic (String access_token, InputStream photo_stream){
		   
		User user;
		FacebookClient facebookClient  = new DefaultFacebookClient(access_token);
		try {
			user = facebookClient.fetchObject("me", User.class);
			
			FacebookType publishPhotoResponse = facebookClient.publish("me/photos",
																		FacebookType.class, 
																		photo_stream,
																		Parameter.with("message", "Photoman"));
			
			System.out.println("User name: " + user.getName());
		
		}catch (FacebookException e) {
			e.printStackTrace();
			return "500";
		}
		return "200";
	}
	
	/**
	 * Method to uploads the picture to Twitter
	 * @param OAuthAccessToken
	 * @param OAuthAccessTokenSecret
	 * @param photo_stream
	 * @param OAuthConsumerKey
	 * @param OAuthConsumerSecret
	 * @param twitpicApiKey
	 * @return String
	 */
	public String twitterUploadPic (String OAuthAccessToken, String OAuthAccessTokenSecret, 
									InputStream photo_stream,String OAuthConsumerKey,
									String OAuthConsumerSecret,String twitpicApiKey) {
		
	
		String url = "" ;
		ConfigurationBuilder confBuilder = new ConfigurationBuilder();
		confBuilder.setDebugEnabled(false);
		
		confBuilder.setOAuthAccessToken(OAuthAccessToken);
		confBuilder.setOAuthAccessTokenSecret(OAuthAccessTokenSecret);
		confBuilder.setOAuthConsumerKey(OAuthConsumerKey);
		confBuilder.setOAuthConsumerSecret(OAuthConsumerSecret);
		confBuilder.setOAuthAccessTokenURL("http://twitter.com/oauth/access_token");
		confBuilder.setOAuthRequestTokenURL("http://twitter.com/oauth/request_token");
		confBuilder.setOAuthAuthorizationURL("http://twitter.com/oauth/authorize");

		Configuration conf = confBuilder.build();
		
		AccessToken twitAccessToken = new AccessToken (OAuthAccessToken, OAuthAccessTokenSecret);
		OAuthAuthorization auth = new OAuthAuthorization(conf,OAuthConsumerKey,
															OAuthConsumerSecret,twitAccessToken);						
		ImageUpload upload = ImageUpload.getTwitpicUploader (twitpicApiKey, auth);
		
		try {
			url = upload.upload("Photoman", photo_stream);
		} catch (TwitterException e) {
			e.printStackTrace();
			return "500|"+url;
		}
		return "200|"+url;
	}
}
