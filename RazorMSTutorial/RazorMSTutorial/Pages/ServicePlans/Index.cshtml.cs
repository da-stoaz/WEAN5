using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Data;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Pages.ServicePlans
{
    public class IndexModel : PageModel
    {
        private readonly RazorMSTutorial.Data.PublicTransportContext _context;

        public IndexModel(RazorMSTutorial.Data.PublicTransportContext context)
        {
            _context = context;
        }

        public IList<ServicePlan> ServicePlan { get;set; } = default!;

        public async Task OnGetAsync()
        {
            ServicePlan = await _context.ServicePlans.ToListAsync();
        }
    }
}
