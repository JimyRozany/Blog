import './Header.css';
import hero from '../../images/hero2.jpg';

const Header = () => {
  return (
    <header className="header_container">
      <div className="hero_image">
        <img src={hero} alt="cover" />
      </div>
      <div className="hero_text">
        <h3>Blog</h3>
        <p>
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis
        magni veniam quaerat praesentium repudiandae autem!
        </p>
        <a href="#">let's Go</a>
        </div>
     
    </header>
  );
};

export default Header;
