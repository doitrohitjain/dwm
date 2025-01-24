<div class="custom-loader mainCls loader hide">
  <div class="cssload-loader">
    <div class="cssload-one"></div>
    <div class="cssload-two"></div>
    <div class="cssload-three"></div>
  </div>
</div>

<style>
  .custom-loader {
    width: 120px;
    height: 120px;
    color: #e1e1e1;
    background: linear-gradient(rgb(14 91 101) 0 0) 100% 0, linear-gradient(rgb(14 91 101) 0 0) 0 100%;
    background-size: 50.1% 50.1%;
	background-repeat: no-repeat;
    animation: f7-0 0.5s infinite linear;
    position: fixed;
    top: 45%;
    left: 45%;
    transform: translate(-50%, -50%);
	pointer-events: none; /* Block interaction with the background */
  }

  .custom-loader::before,
  .custom-loader::after {
    content: "";
    position: absolute;
    inset: 0 50% 50% 0;
    background: currentColor;
    transform: scale(var(--s, 1)) perspective(300px) rotateY(0deg);
    transform-origin: bottom right;
    animation: f7-1 0.25s infinite linear alternate;
  }

  .custom-loader::after {
    --s: -1, -1;
  }

  .cssload-loader {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }

  .cssload-inner {
    width: 20px;
    height: 20px;
    margin: 5px;
    background-color: #fff;
    border-radius: 50%;
    animation: bounce 0.6s infinite alternate;
  }

  .cssload-one {
    animation-delay: 0s;
  }

  .cssload-two {
    animation-delay: 0.2s;
  }

  .cssload-three {
    animation-delay: 0.4s;
  }

  @keyframes f7-0 {
    0%,
    49.99% {
      transform: scaleX(1) rotate(0deg);
    }
    50%,
    100% {
      transform: scaleX(-1) rotate(-90deg);
    }
  }

  @keyframes f7-1 {
    49.99% {
      transform: scale(var(--s, 1)) perspective(300px) rotateX(-90deg);
      filter: grayscale(0);
    }
    50% {
      transform: scale(var(--s, 1)) perspective(300px) rotateX(-90deg);
      filter: grayscale(0.8);
    }
    100% {
      transform: scale(var(--s, 1)) perspective(300px) rotateX(-180deg);
      filter: grayscale(0.8);
    }
  }

  @keyframes bounce {
    0%,
    100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px);
    }
  } 
	  
</style>
