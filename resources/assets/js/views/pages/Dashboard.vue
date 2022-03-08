<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <card
          :title="stats.aspirants.title"
          :value="stats.aspirants.value"
          :percentage="stats.aspirants.percentage"
          :iconClass="stats.aspirants.iconClass"
          :iconBackground="stats.iconBackground"
          directionReverse
        ></card>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <card
          :title="stats.users.title"
          :value="stats.users.value"
          :percentage="stats.users.percentage"
          :iconClass="stats.users.iconClass"
          :iconBackground="stats.iconBackground"
          directionReverse
        ></card>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <card
          :title="stats.agents.title"
          :value="stats.agents.value"
          :percentage="stats.agents.percentage"
          :iconClass="stats.agents.iconClass"
          :iconBackground="stats.iconBackground"
          :percentageColor="stats.agents.percentageColor"
          directionReverse
        ></card>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0">
        <card
          :title="stats.pollings.title"
          :value="stats.pollings.value"
          :percentage="stats.pollings.percentage"
          :iconClass="stats.pollings.iconClass"
          :iconBackground="stats.iconBackground"
          directionReverse
        ></card>
      </div>
    </div>
    <div class="mt-4 row">
      <div class="mb-4 col-lg-5 mb-lg-0">
        <div class="card z-index-2">
          <div class="p-3 card-body">
            <!-- chart -->
            <active-users-chart />
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <!-- line chart -->
        <div class="card z-index-2">
          <gradient-line-chart />
        </div>
      </div>
    </div>
    <!-- <div class="row my-4">
      <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <projects-card />
      </div>
      <div class="col-lg-4 col-md-6">
        <Orders-card />
      </div>
    </div> -->
  </div>
</template>
<script>
import Card from "../../examples/Cards/Card.vue";
import ActiveUsersChart from "../../examples/Charts/ActiveUsersChart.vue";
import GradientLineChart from "../../examples/Charts/GradientLineChart.vue";
import OrdersCard from "../components/OrdersCard.vue";
import ProjectsCard from "../components/ProjectsCard.vue";
import US from "../../assets/img/icons/flags/US.png";
import DE from "../../assets/img/icons/flags/DE.png";
import GB from "../../assets/img/icons/flags/GB.png";
import BR from "../../assets/img/icons/flags/BR.png";

export default {
  name: "dashboard-default",
  data() {
    return {
      stats: {
        users_count: '',
        aspirants_count: '',
        iconBackground: "bg-gradient-success",
        aspirants: {
          title: "Total Aspirants",
          value: "",
          percentage: "+55%",
          iconClass: "ni ni-money-coins",
        },
        users: {
          title: "Total Votes Cast",
          value: "",
          percentage: "+3%",
          iconClass: "ni ni-world",
        },
        agents: {
          title: "Total Agents",
          value: "",
          percentage: "-2%",
          iconClass: "ni ni-paper-diploma",
          percentageColor: "text-danger",
        },
        pollings: {
          title: "Total Pollings",
          value: "",
          percentage: "+5%",
          iconClass: "ni ni-cart",
        },
      },
      sales: {
        us: {
          country: "United States",
          sales: 2500,
          value: "$230,900",
          bounce: "29.9%",
          flag: US,
        },
        germany: {
          country: "Germany",
          sales: "3.900",
          value: "$440,000",
          bounce: "40.22%",
          flag: DE,
        },
        britain: {
          country: "Great Britain",
          sales: "1.400",
          value: "$190,700",
          bounce: "23.44%",
          flag: GB,
        },
        brasil: {
          country: "Brasil",
          sales: "562",
          value: "$143,960",
          bounce: "32.14%",
          flag: BR,
        },
      },
    };
  },
  components: {
    Card,
    ActiveUsersChart,
    GradientLineChart,
    ProjectsCard,
    OrdersCard,
  },
 
  mounted() {
      axios.get('/api/v1/user/dashboard').then(response =>  {
          // this.stats.users.value = response.data.users_count;
          // this.stats.aspirants.value = response.data.aspirants_count;
          // console.log(response.data);
      });
  },
};
</script>
